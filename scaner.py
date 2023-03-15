import subprocess

# Define the target website
target = "https://example.com"

# Define the output file for Nikto's report
output_file = "nikto_report.txt"

# Define the Nikto command with the desired options
nikto_command = ["nikto", "-h", target, "-o", output_file, "-Format", "txt", "-Plugins", "xss,headers,apacheusers,put,dir_listing"]

# Run the Nikto command and capture the output
nikto_output = subprocess.run(nikto_command, capture_output=True, text=True)

# Print the Nikto output to the console
print(nikto_output.stdout)

# Optionally, you can send an email with the Nikto report as an attachment
import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

# Define the email addresses
sender_email = "your_email@example.com"
receiver_email = "recipient_email@example.com"

# Create the email message
message = MIMEMultipart()
message["From"] = sender_email
message["To"] = receiver_email
message["Subject"] = f"Nikto report for {target}"

# Read the Nikto report from the output file
with open(output_file, "r") as file:
    report = file.read()

# Create a MIMEText object with the report as the message body
message_body = MIMEText(report)

# Attach the message body to the email message
message.attach(message_body)

# Send the email
with smtplib.SMTP("smtp.gmail.com", 587) as server:
    server.starttls()
    server.login(sender_email, "your_password")
    server.sendmail(sender_email, receiver_email, message.as_string())

# Delete the output file
import os
os.remove(output_file)
