# mailtrapper
A mailtrap.io API wrapper class. Use it to get a list of your Mailtrap.io inboxes and mails.

## Usage
```php
$mt = new CrazyInventor\Mailtrapper([YOUR_MAILTRAP_API_TOKEN]);
$inboxes = $mt->getInboxes();
$mails = $mt->getMails([YOUR_MAILTRAP_INBOX_ID]);
```
