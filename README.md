# SensoricNet-udp


INSTALL
-------


* copy example .service file to systemd folder

```
cp sensoricnet-udp.service /etc/systemd/system/sensoricnet-udp.service
```

and enable and start it

```
systemctl daemon-reload
systemctl start sensoricnet-udp
systemctl enable sensoricnet-udp
```



testing

```
echo -n "hello" | nc -4 -u localhost 9999
```
