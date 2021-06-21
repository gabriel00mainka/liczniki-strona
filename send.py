import serial
import time
import sys
from time import sleep
from datetime import datetime
from mysql.connector import connect
from azure.iot.device import IoTHubDeviceClient, Message 

CONNECTION_STRING_TO = "HostName=liczniki.azure-devices.net;DeviceId=Raspberry;SharedAccessKey=OHJDmZXZgUz3wjloB9znIh077B79HtpTSqwIwkXo290="

msg_to_azure = """{{"date_time": {date_time},"date_time_ms": {date_time_ms},"date_time_zone": {date_time_zone},
"id_h": {id_h},"id_d": {id_d},"id_c": {id_c},"msrt": {msrt}}}"""

# msg_to_azure = """{{"msrt": {msrt}}}"""
# msg_to_azure = """{{"id_h": {id_h},"id_d": {id_d},"id_c": {id_c},"msrt": {msrt}}}"""

def iothub_client_init():  
    client = IoTHubDeviceClient.create_from_connection_string(CONNECTION_STRING_TO)  
    # client_from = IoTHubDeviceClient.create_from_connection_string(CONNECTION_STRING_FROM)
    return client

try:
    db = connect(
        host = "localhost",
        user = "gabriel",
        passwd = "haslo123",
        database = "liczniki"
    )
except:
    print("Nie udalo polaczyc sie z baza danych!")
    sys.exit()

cursor = db.cursor()

try:
    client = iothub_client_init() 
    print ( "IoT Hub is connected" )
    
    cursor.execute("SELECT date_time, date_time_ms, date_time_zone, id_h, id_d, id_c, msrt FROM msrts_15 WHERE id_c=0 AND send_to_azure=0")

    download = cursor.fetchall()
    db.commit()

    for i in download:
        # print(i[0])
        czas_baza,ms,tm_zone,id_h,id_d,id_c,msrt = i 
        # date_time=czas_baza, date_time_ms=ms,date_time_zone=tm_zone,id_h=id_h,id_d=id_d,id_c=id_c,
        msg_txt_formatted = msg_to_azure.format(date_time=czas_baza, date_time_ms=ms,date_time_zone=tm_zone,id_h=id_h,id_d=id_d,id_c=id_c,msrt=msrt)
        message = Message(msg_txt_formatted)
        try:
            client.send_message(message)

            question = "update msrts_15 set send_to_azure=1 where date_time='" + str(czas_baza) + "' and date_time_ms=" + str(ms) + " and date_time_zone=" + str(tm_zone) + " and id_h=" + str(id_h) + " and id_d=" + str(id_d) +  " and id_c=" + str(id_c)
            cursor.execute(question)
            db.commit()
            print ( "IoT Hub device sending message" )
        except:
            print("Brak połączenia!")
        sleep(1)


except KeyboardInterrupt:
    pass