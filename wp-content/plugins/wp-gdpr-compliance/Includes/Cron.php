<?php

namespace WPGDPRC\Includes;

/**
 * Class Cron
 * @package WPGDPRC\Includes
 */
class Cron {
    /** @var null */
    private static $instance = null;

    /**
     * @param array $schedules
     * @return array
     */
    public function addCronSchedules($schedules = array()) {
        // Once a month
        $schedules['wpgdprc-monthly'] = array(
            'interval' => 2635200,
            'display' => __('Once a month', WP_GDPR_C_SLUG),
        );
        return $schedules;
    }

    /**
     * Deactivate requests after 24 hours
     */
    public function deactivateAccessRequests() {
        $date = Helper::localDateTime(time());
        $date->modify('-24 hours');
        $requests = AccessRequest::getInstance()->getList(array(
            'expired' => array(
                'value' => 0
            ),
            'date_created' => array(
                'value' => $date->format('Y-m-d H:i:s'),
                'compare' => '<='
            )
        ));
        if (!empty($requests)) {
            foreach ($requests as $request) {
                $request->setExpired(1);
                $request->save();
            }
        }
    }

    /**
     * Anonymise requests after 1 month
     */
    public function anonymiseRequests() {
        $date = Helper::localDateTime(time());
        $aMonthAgo = clone $date;
        $aMonthAgo->modify('-1 month');
        $arguments = array(
            'ip_address' => array(
                'value' => '127.0.0.1',
                'compare' => '!='
            ),
            'date_created' => array(
                'value' => $aMonthAgo->format('Y-m-d H:i:s'),
                'compare' => '<='
            )
        );
        $accessRequests = AccessRequest::getInstance()->getList($arguments);
        $deleteRequests = DeleteRequest::getInstance()->getList($arguments);
        foreach ($accessRequests as $accessRequest) {
            $accessRequest->setEmailAddress(($accessRequest->getId() . '.' . $date->format('Ymd.His') . '@example.org'));
            $accessRequest->setIpAddress('127.0.0.1');
            $accessRequest->setExpired(1);
            $accessRequest->save();
        }
        foreach ($deleteRequests as $deleteRequest) {
            $deleteRequest->setIpAddress('127.0.0.1');
            $deleteRequest->setDataId(0);
            $deleteRequest->setType('unknown');
            $deleteRequest->save();
        }
    }

    /**
     * @return null|Cron
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}