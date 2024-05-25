import socket

def scan_ports(hostname, start_port, end_port):
    ports = {}
    for port in range(start_port, end_port + 1):
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        sock.settimeout(1)
        result = sock.connect_ex((hostname, port))
        if result == 0:
            ports[port] = 'open'
        else:
            ports[port] = 'closed'
        sock.close()
    return ports

hostname = input("Ingrese el nombre de host o la dirección IP: ")
start_port = int(input("Ingrese el puerto inicial: "))
end_port = int(input("Ingrese el puerto final: "))

ports = scan_ports(hostname, start_port, end_port)

for port, status in ports.items():
    print(f"Port {port} is {status}")