function showTime() {
    var dateTime = new Date();
    const weekdayName = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    const monthName = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var time = dateTime.getHours() + ":" + dateTime.getMinutes() + ":" + dateTime.getSeconds()
                + " " + weekdayName[dateTime.getDay()] + "/" + monthName[dateTime.getMonth()]
                + "/" + dateTime.getFullYear();
    document.getElementById("time").innerHTML = time;
    setTimeout(showTime, 1000);
}