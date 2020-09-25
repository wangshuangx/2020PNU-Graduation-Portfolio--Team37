import gatt
f = open("data.txt", 'w')

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
        #print("ok", value.decode("utf-8"))
        f.write(value.decode("utf-8").split('\n')[0])
        f.write('\n')
device = AnyDevice(mac_address="E4:78:DB:3A:AA:86", manager=manager)
device.connect()

manager.run()
f.close()
