import serial

ser = serial.Serial("/dev/ttyUSB0",9600)
ser.timeout = 1

ser.write(b'\x01\x03\x00\x00\x00\x03\x05\xcb')
stan_byte = ser.read(11)
stan_int = (stan_byte[4]*256**2 + stan_byte[6]*256 + stan_byte[8])/100

print(str(stan_int))