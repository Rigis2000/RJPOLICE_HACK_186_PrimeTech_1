from twilio.rest import Client

account_sid = 'AC590bcb984ba74908db827d06c0d639cd'
auth_token = 'e6a999779a456d5466d3adaf9148e092'

twilio_phone_number = '+12059316077'

recipient_phone_number = ['+919462205207',"+916377957714"]

link_url = 'http://10.255.2.163/PFS_Final/oneclick/oneclickfeedback.html'

client = Client(account_sid, auth_token)
for number in recipient_phone_number:
    message = client.messages.create(
        body=f'Click the link to give feedback: {link_url}',
        from_=twilio_phone_number,
        to=number
    )

print(f'SMS sent successfully. Message SID: {message.sid}')
