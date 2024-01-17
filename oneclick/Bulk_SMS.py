from twilio.rest import Client

account_sid = 'AC590bcb984ba74908db827d06c0d639cd'
auth_token = '3facfa87a2403fe48d761d8eeb81ff68'

twilio_phone_number = '+12059316077'

recipient_phone_number = '+919462205207'

link_url = 'https://rajasthanpolicefeedback.000webhostapp.com/home.html'

client = Client(account_sid, auth_token)

message = client.messages.create(
    body=f'Click the link to give feedback: {link_url}',
    from_=twilio_phone_number,
    to=recipient_phone_number
)

print(f'SMS sent successfully. Message SID: {message.sid}')
