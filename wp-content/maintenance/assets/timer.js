// Copyright 1999-2017. Plesk IP Holdings GmbH. All Rights Reserved.
var startTimer = function(days, hours, minutes, startTime, timeShift) {
    var currentDateInSeconds = Math.floor(Date.now() / 1000);
    var endTime = startTime + (days * 86400) + (hours * 3600) + (minutes * 60);
    var diff = Math.max(0, endTime - currentDateInSeconds - timeShift);

    displayTimerValues(diff);

    if (0 < diff) {
        setTimeout(function() {
            startTimer(days, hours, minutes, startTime, timeShift);
        }, 1000);
    }
};

var displayTimerValues = function (diff) {
    var currentDays = Math.floor(diff / 86400);
    diff -= currentDays * 86400;

    var currentHours = Math.floor(diff / 3600) % 24;
    diff -= currentHours * 3600;

    var currentMinutes = Math.floor(diff / 60) % 60;
    diff -= currentMinutes * 60;

    var seconds = diff % 60;
    fillTimerValue("timerResultDays", currentDays);
    fillTimerValue("timerResultHours", currentHours);
    fillTimerValue("timerResultMinutes", currentMinutes);
    fillTimerValue("timerResultSeconds", seconds);
};

var fillTimerValue = function(elementName, value) {
    var element = document.getElementById(elementName);
    if (element) {
        element.innerHTML = (value < 10) ? "0" + value : value;
    }
};
