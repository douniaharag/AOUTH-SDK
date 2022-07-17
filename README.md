# AOUTH-SDK

This is a project for the course `Intégration SDK`. The goal is to create an OAuth SDK with multiple services like Facebook, GitHub, Google, Discord... and to use our own OAuth server to perform OAuth.

## OAuth services used

- Facebook (https://developers.facebook.com/docs/facebook-login/web/)
- GitHub (https://docs.github.com/en/developers/apps/building-oauth-apps/authorizing-oauth-apps)
- Discord (https://discord.com/developers/docs/topics/oauth2)
- Google (https://developers.google.com/identity/sign-in/web/sign-in)
- Our own SDK server

## Run the project

### Clone the project

Use `git clone https://github.com/douniaharag/AOUTH-SDK.git`

### Run the project with Docker

**_Make sure the ports `80` (for HTTP), `443` (for HTTPS) and `8081` (for our own OAuth server) are free otherwise the docker won't start_**

Run the command `docker-compose up` in the root directory
