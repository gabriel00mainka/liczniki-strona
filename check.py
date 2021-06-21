import os
import sys
from time import sleep
import subprocess
from datetime import datetime
from mysql.connector import connect

insert_status = """INSERT INTO status_program (date_time,value_status) VALUES (%s,%s)"""

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
    run_once = 0
    while True:
        tm = datetime.utcnow()
        czas = tm.strftime("%Y-%m-%d %H:%M:%S")
        s1 = subprocess.Popen(r"ps -e -o pid,args | grep 'python3 main1.py' | grep -v grep | sed 's/^\s*//g' | cut -d' ' -f1", shell=True, stdout=subprocess.PIPE)
        nr_pid = s1.stdout.read()
        
        if len(nr_pid) > 1:
            # print(czas)
            # print(int(nr_pid))
            value_status = 1
            cursor.execute(insert_status,(czas,value_status,))
            db.commit()
            sleep(1)

        else:
            print("\n--- program main1.py nie dziala (UTC: "+ czas +") ! ---\n")
            # os.system("python3 main1.py")
            p1 = subprocess.Popen(['python3','main1.py'])
            file = open("check_data.txt","a")
            file.write("\nProgram main1.py przestał działać (UTC: "+czas + ")\n")
            file.close()
            value_status = 0
            cursor.execute(insert_status,(czas,value_status,))
            db.commit()
            sleep(1)
except KeyboardInterrupt:
    tm = datetime.utcnow()
    czas = tm.strftime("%Y-%m-%d %H:%M:%S")
    file = open("check_data.txt","a")
    file.write("Program check.py został zakmnięty (UTC: " + czas +")\n")
    file.close()
    value_status = 0
    cursor.execute(insert_status,(czas,value_status,))
    db.commit()
    sleep(1)
    pass
