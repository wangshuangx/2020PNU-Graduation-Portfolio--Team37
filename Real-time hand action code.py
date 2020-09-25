import tensorflow as tf
from tensorflow import keras
from sklearn.model_selection import train_test_split
import numpy as np
import matplotlib.pyplot as plt
from sklearn.metrics import confusion_matrix
import os
import gatt
import pymysql

from threading import Thread


flag=Fasle
WINDOW_SIZE=0
image=[];
manager = gatt.DeviceManager(adapter_name='hci0')

class AnyDevice(gatt.Device):
    def connect_succeeded(self):
        super().connect_succeeded()
        print("[%s] Connected" % (self.mac_address))

    def connect_failed(self, error):
        super().connect_failed(error)
        print("[%s] Connection failed: %s" % (self.mac_address, str(error)))

    def disconnect_succeeded(self):
        super().disconnect_succeeded()
        print("[%s] Disconnected" % (self.mac_address))

    def services_resolved(self):
        super().services_resolved()
        noti_service = next(s for s in self.services if s.uuid == '6e400001-b5a3-f393-e0a9-e50e24dcca9e')
        noti_characteristic = next(c for c in noti_service.characteristics if c.uuid == '6e400003-b5a3-f393-e0a9-e50e24dcca9e')
        noti_characteristic.enable_notifications()
        
        print("[%s] Resolved services" % (self.mac_address))
        for service in self.services:
            print("[%s]  Service [%s]" % (self.mac_address, service.uuid))
            for characteristic in service.characteristics:
                print("[%s]    Characteristic [%s]" % (self.mac_address, characteristic.uuid))

    def characteristic_value_updated(self, characteristic, value):
	    if flag==0:
		    image.append(value.decode("utf-8").split('\n')[0].split(','))
		    WINDOW_SIZE +=1
		if WINDOW_SIZE==30 :
			flag=1
			WINDOW_SIZE=0

def bleCon():
    device = AnyDevice(mac_address="ED:56:0F:C5:94:AC", manager=manager)
    device.connect()
	#device = AnyDevice(mac_address="E4:78:DB:3A:AA:86", manager=manager)
	manager.run()

if __name__ == "__main__":
	train_image[]
	model = tf.keras.models.load_model('my_model.h5')
	
    th1 = Thread(target=bleCon)
	th1.start()
	class_names = ['washingHand', 'brushingTooth', 'drinking', 'washingFace', 'washingHair', 'running', 'dryingHair','sitting','standing','walking']
	while True:
	    if flag==1 :
		    train_image=np.asarray(image)
			train_image=train_image.reshape(1,30,6,1)
		    Y_pred=model.predict(train_image)
		    Y_pred_classes = np.argmax(Y_pred, axis = 1)
		    print(class_names[Y_pred_classes[0]])
	
	
	
