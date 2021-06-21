import serial
import sys
import time
import os
from time import sleep
from datetime import datetime
from mysql.connector import connect
from send import *

ser = serial.Serial("/dev/ttyUSB0",9600)
ser.timeout = 1

global insert_msrts
global insert_msrt_points
global insert_msrt_points_local

id_h = 0
id_d = [1,2,3,4,5]
id_c = [0,1]

insert_msrts_1 = """INSERT INTO msrts_1 (date_time,date_time_ms, date_time_zone,
id_h, id_d, id_c,
msrt, status) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)"""

insert_msrts_15 = """INSERT INTO msrts_15 (date_time,date_time_ms, date_time_zone,
id_h, id_d, id_c,
msrt, status, send_to_azure) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,0)"""

insert_msrt_points = """INSERT INTO msrt_points (id_h, id_d, id_c, type, location) VALUES (%s,%s,%s,%s,%s)"""

insert_msrt_type = """INSERT INTO msrt_type (type, name, description) VALUES (%s,%s,%s)"""

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
    ser.write(b'\x01\x03\x00\x00\x00\x03\x05\xcb')
    sleep(0.01)
    stan = ser.read(11)
    old_1 = (stan[4]*256**2 + stan[6]*256 + stan[8])/100
    old_15 = old_1

    while True:
        tm = datetime.utcnow() 

        if (tm.second == 0):
            ser.write(b'\x01\x03\x00\x00\x00\x03\x05\xcb')

            czas_baza = tm.strftime("%Y-%m-%d %H:%M:%S")
            ms = tm.strftime("%f")[0:3]

            print("Odczytane:",czas_baza)
            sleep(0.01)

            stan_byte = ser.read(11)
            # print(stan_byte)

            stan_int = (stan_byte[4]*256**2 + stan_byte[6]*256 + stan_byte[8])/100
            print(stan_int)

            tm_l = datetime.now()
            tm_zone = str(tm_l-tm).split(':')[0]

            if (tm.minute % 15 == 0):
                cursor.execute(insert_msrts_15,(czas_baza, ms, tm_zone,id_h,id_d[0],id_c[0],stan_int,0))
                cursor.execute(insert_msrts_15,(czas_baza, ms, tm_zone,id_h,id_d[0],id_c[1],stan_int - old_15,0))
                old_15 = stan_int
                db.commit()
                os.system("python3 send.py")
                print("zczytano z licznika 1")

            cursor.execute(insert_msrts_1,(czas_baza, ms, tm_zone,id_h,id_d[0],id_c[0],stan_int,0))
            cursor.execute(insert_msrts_1,(czas_baza, ms, tm_zone,id_h,id_d[0],id_c[1],stan_int - old_1,0))
            old_1 = stan_int
            db.commit()
#####################################################################################################################   LICZNIK 2
            if (tm.minute % 30 == 0):
                cursor.execute(insert_msrts_15,(czas_baza, ms, tm_zone,id_h,id_d[1],id_c[0],stan_int,0))
                cursor.execute(insert_msrts_15,(czas_baza, ms, tm_zone,id_h,id_d[1],id_c[1],stan_int - old_15,0))
                old_15 = stan_int
                db.commit()
                os.system("python3 send.py")
                print("zczytano z licznika 2")

            cursor.execute(insert_msrts_1,(czas_baza, ms, tm_zone,id_h,id_d[1],id_c[0],stan_int,0))
            cursor.execute(insert_msrts_1,(czas_baza, ms, tm_zone,id_h,id_d[1],id_c[1],stan_int - old_1,0))
            old_1 = stan_int
            db.commit()
#####################################################################################################################   LICZNIK 3
            if (tm.minute % 25 == 0):
                cursor.execute(insert_msrts_15,(czas_baza, ms, tm_zone,id_h,id_d[2],id_c[0],stan_int,0))
                cursor.execute(insert_msrts_15,(czas_baza, ms, tm_zone,id_h,id_d[2],id_c[1],stan_int - old_15,0))
                old_15 = stan_int
                db.commit()
                os.system("python3 send.py")
                print("zczytano z licznika 3")

            cursor.execute(insert_msrts_1,(czas_baza, ms, tm_zone,id_h,id_d[2],id_c[0],stan_int,0))
            cursor.execute(insert_msrts_1,(czas_baza, ms, tm_zone,id_h,id_d[2],id_c[1],stan_int - old_1,0))
            old_1 = stan_int
            db.commit()
#####################################################################################################################   LICZNIK 4
            if (tm.minute % 45 == 0):
                cursor.execute(insert_msrts_15,(czas_baza, ms, tm_zone,id_h,id_d[3],id_c[0],stan_int,0))
                cursor.execute(insert_msrts_15,(czas_baza, ms, tm_zone,id_h,id_d[3],id_c[1],stan_int - old_15,0))
                old_15 = stan_int
                db.commit()
                os.system("python3 send.py")
                print("zczytano z licznika 4")

            cursor.execute(insert_msrts_1,(czas_baza, ms, tm_zone,id_h,id_d[3],id_c[0],stan_int,0))
            cursor.execute(insert_msrts_1,(czas_baza, ms, tm_zone,id_h,id_d[3],id_c[1],stan_int - old_1,0))
            old_1 = stan_int
            db.commit()
#####################################################################################################################   LICZNIK 5
            if (tm.minute % 20 == 0):
                cursor.execute(insert_msrts_15,(czas_baza, ms, tm_zone,id_h,id_d[4],id_c[0],stan_int,0))
                cursor.execute(insert_msrts_15,(czas_baza, ms, tm_zone,id_h,id_d[4],id_c[1],stan_int - old_15,0))
                old_15 = stan_int
                db.commit()
                os.system("python3 send.py")
                print("zczytano z licznika 5")

            cursor.execute(insert_msrts_1,(czas_baza, ms, tm_zone,id_h,id_d[4],id_c[0],stan_int,0))
            cursor.execute(insert_msrts_1,(czas_baza, ms, tm_zone,id_h,id_d[4],id_c[1],stan_int - old_1,0))
            old_1 = stan_int
            db.commit()
            sleep(1)
        
except KeyboardInterrupt:
    pass
