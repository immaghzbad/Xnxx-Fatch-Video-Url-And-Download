# Fetch Videos

**Note: This content is intended for adults (+18) only. Misuse of this application is the responsibility of the user.**

This project is a simple web application that allows users to fetch video URLs from the website `xnxx.com`. By entering a valid URL and a license key, users can retrieve video links in different qualities (Low, High, HLS) and download them directly.

## Features

- **Fetch Videos**: Enter the URL of a video page on `xnxx.com` and get the video links.
- **License Validation**: Ensures that only users with a valid license key can fetch video links.
- **Copy and Download Links**: Users can copy video links to the clipboard or download the videos directly.

## How to Use

1. **Enter the URL**: Paste the URL of the video page from `xnxx.com` that you want to fetch.
2. **Enter the License Key**: Provide your license key to validate access.
3. **Fetch Videos**: Click the "Fetch Videos" button to retrieve the video links.
4. **Copy or Download**: Use the provided buttons to copy the video links or download the videos.

## Setting Up the License Key

The license key is hardcoded in the script for validation. Currently, the key is set to `dbxjsk029jd`. To change this:

1. Locate the `define('LICENSE_KEY', 'dbxjsk029jd');` line in the PHP script.
2. Replace `dbxjsk029jd` with your desired license key.

```php
define('LICENSE_KEY', 'your_new_license_key');
```

## Example Usage

1. Enter the URL: `https://www.xnxx.com/video-abc123`
2. Enter the License Key: `dbxjsk029jd`
3. Click "Fetch Videos"
4. See the results below the form, with options to copy or download the video links.

## Social Media

For more projects and updates, follow the developer on Telegram: [PowerSigma](https://t.me/PowerSigma)

---
