import subprocess

# Define the target website
target = "example.com"

# Run ZMap to perform a scan of the target website
zmap_output = subprocess.check_output(['zmap', '-p', '80,443', '-o', '-', target])

# Parse the ZMap output to extract the list of open ports
open_ports = []
for line in zmap_output.splitlines():
    if "80/open" in line or "443/open" in line:
        port = line.split()[1].split("/")[0]
        open_ports.append(port)

# Run a vulnerability scanner on the open ports
for port in open_ports:
    print("Scanning port", port, "for vulnerabilities...")
    subprocess.call(['nmap', '-sV', '-Pn', '-p'+port, '-script=vuln', target])
