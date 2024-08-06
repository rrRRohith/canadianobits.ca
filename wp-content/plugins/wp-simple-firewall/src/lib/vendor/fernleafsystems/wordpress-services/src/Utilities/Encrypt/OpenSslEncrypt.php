<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Encrypt;

use FernleafSystems\Wordpress\Services\Services;

class OpenSslEncrypt {

	/**
	 * @throws \Exception
	 */
	#[\JetBrains\PhpStorm\ArrayShape( [ "private" => "string", "public" => "string" ] )]
	public function createNewPrivatePublicKeyPair( array $args = [] ) :array {
		$key = \openssl_pkey_new( $args );
		if ( empty( $key ) ) {
			throw new \Exception( '[OPENSSL] New Private Key was empty' );
		}
		if ( !\is_resource( $key )
			 && ( $this->usePHP8() && !$key instanceof \OpenSSLAsymmetricKey ) ) {
			throw new \Exception( '[OPENSSL] Could not generate new private key' );
		}
		if ( !\openssl_pkey_export( $key, $private ) || empty( $private ) ) {
			throw new \Exception( 'Could not export new private key' );
		}
		$pub = \openssl_pkey_get_details( $key );
		if ( empty( $pub ) || empty( $pub[ 'key' ] ) ) {
			throw new \Exception( 'Could not generate public key from private' );
		}
		return [
			'private' => $private,
			'public'  => $pub[ 'key' ],
		];
	}

	/**
	 * @param \OpenSSLAsymmetricKey|string $privateKey
	 * @throws \Exception
	 */
	public function getPublicKeyFromPrivateKey( $privateKey ) :string {
		$key = \openssl_pkey_get_private( $privateKey );
		if ( empty( $key ) ) {
			throw new \Exception( '[OPENSSL] Extracted Private Key was empty' );
		}
		if ( !\is_resource( $key )
			 && ( $this->usePHP8() && !$key instanceof \OpenSSLAsymmetricKey ) ) {
			throw new \Exception( '[OPENSSL] Could not generate new private key' );
		}

		$public = \openssl_pkey_get_details( $key );
		if ( empty( $public ) || empty( $public[ 'key' ] ) ) {
			throw new \Exception( 'Could not generate public key from private' );
		}
		return $public[ 'key' ];
	}

	/**
	 * @param \OpenSSLAsymmetricKey|string $privateKey
	 * @return string|false
	 */
	public function openDataVo( OpenSslEncryptVo $VO, $privateKey ) {
		$success = \openssl_open(
			$VO->sealed_data,
			$openedData,
			$VO->sealed_password,
			$privateKey,
			$VO->cipher,
			$VO->iv
		);
		return $success ? $openedData : false;
	}

	/**
	 * @param string $sealedData
	 * @param string $sealedPassword
	 * @param string $privateKey
	 * @return string|false
	 * @deprecated
	 */
	public function openData( $sealedData, $sealedPassword, $privateKey, string $cipher = 'rc4' ) {
		$success = \openssl_open( $sealedData, $openedData, $sealedPassword, $privateKey, $cipher );
		return $success ? $openedData : false;
	}

	/**
	 * @param mixed  $mDataToEncrypt
	 * @param string $publicKey
	 */
	public function sealData( $mDataToEncrypt, $publicKey, $cipher = 'rc4', $iv = null, bool $fallbackRC4 = false ) :OpenSslEncryptVo {

		$VO = $this->getStandardEncryptResponse();

		if ( empty( $mDataToEncrypt ) ) {
			$VO->success = false;
			$VO->message = 'Data to encrypt was empty';
			return $VO;
		}
		elseif ( !$this->isSupportedOpenSslDataEncryption() ) {
			$VO->success = false;
			$VO->message = 'Does not support OpenSSL data encryption';
		}
		elseif ( !$this->cipherExists( $cipher ) ) {
			$VO->message = sprintf( 'Defaulting to RC4 as cipher %s is not available', $cipher );
			$cipher = 'rc4';
		}
		else {
			$VO->success = true;
		}

		// If at this stage we're not 'success' we return it.
		if ( !$VO->success ) {
			return $VO;
		}

		$VO->cipher = $cipher;
		$VO->iv = $iv;

		if ( \is_string( $mDataToEncrypt ) ) {
			$finalDataToEncrypt = $mDataToEncrypt;
			$VO->json_encoded = false;
		}
		else {
			$finalDataToEncrypt = \json_encode( $mDataToEncrypt );
			$VO->json_encoded = true;
		}

		$passwordKeys = [];
		$mResult = \openssl_seal(
			$finalDataToEncrypt,
			$encryptedData,
			$passwordKeys,
			[ $publicKey ],
			$cipher,
			$iv
		);

		$VO->result = $mResult;
		$VO->success = is_int( $mResult ) && $mResult > 0 && !is_null( $encryptedData );
		if ( $VO->success ) {
			$VO->sealed_data = $encryptedData;
			$VO->sealed_password = $passwordKeys[ 0 ];
		}
		else {
			$VO->message = sprintf( 'openssl_seal() result was "%s".', var_export( $mResult, true ) );
			if ( is_null( $encryptedData ) ) {
				$VO->message .= ' Encrypted data was null.';
			}
		}

		if ( $cipher !== 'rc4' && $fallbackRC4 ) {
			// we do a backup seal as rc4 while we determine availability of other cipers
			$VO->rc4_fallback = $this->sealData( $mDataToEncrypt, $publicKey );
		}

		return $VO;
	}

	public function isSupportedOpenSsl() :bool {
		return \extension_loaded( 'openssl' );
	}

	public function isSupportedOpenSslSign() :bool {
		return \function_exists( '\base64_decode' )
			   && \extension_loaded( 'openssl' )
			   && \function_exists( '\openssl_sign' )
			   && \function_exists( '\openssl_verify' )
			   && \defined( 'OPENSSL_ALGO_SHA1' );
	}

	public function isSupportedOpenSslDataEncryption() :bool {
		$required = [
			'openssl_seal',
			'openssl_open',
			'openssl_pkey_new',
			'openssl_pkey_export',
			'openssl_pkey_get_details',
			'openssl_pkey_get_private',
			'openssl_get_cipher_methods',
		];
		return $this->isSupportedOpenSsl()
			   && \count( $required ) === \count( \array_filter( \array_map( '\function_exists', $required ) ) );
	}

	/**
	 * @param string $verificationCode
	 * @param string $signature
	 * @param string $publicKey
	 * @return int|false         1: Success; 0: Failure; -1: Error; -2: Not supported
	 */
	public function verifySslSignature( $verificationCode, $signature, $publicKey ) {
		$result = -2;
		if ( $this->isSupportedOpenSslSign() ) {
			$result = \openssl_verify( $verificationCode, $signature, $publicKey );
		}
		return $result;
	}

	protected function getStandardEncryptResponse() :OpenSslEncryptVo {
		return new OpenSslEncryptVo();
	}

	public function cipherExists( string $cipher ) :bool {
		return \in_array( \strtolower( $cipher ), \array_map( '\strtolower', \openssl_get_cipher_methods( true ) ) );
	}

	private function usePHP8() :bool {
		return Services::Data()->getPhpVersionIsAtLeast( '8.0' ) && @\class_exists( '\OpenSSLAsymmetricKey' );
	}

	/**
	 * @deprecated 3.0
	 */
	public function hasCipherAlgo( string $cipher ) :bool {
		return $this->cipherExists( $cipher );
	}
}