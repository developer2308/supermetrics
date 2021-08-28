# TASK
1. Register a short-lived token on the fictional Supermetrics Social Network REST API
2. Fetch the posts of fictional users on a fictional social platform and process their posts.
3. You will have 1000 posts over a six month period.
4. Show stats on the following:
   - Average character length of posts per month
   - Longest post by character length per month
   - Total posts split by week number
   - Average number of posts per user per month
5. Design your thinking and code to be generic, extendable, easy to maintain by other staff
members while thinking about performance.

You do not need to create any HTML pages for the display of the data. JSON output of the
stats is sufficient.

# API Docs
## Use the following endpoint to register a token:
* POST: https://api.supermetrics.com/assignment/register
* PARAMS:
```
client_id: ju16a6m81mhid5ue1z3v2g0uh
email: your@email.address
name: Your Name
```
* RETURNS:
```
sl_token: This token string should be used in the subsequent
query. Please note that this token will only last 1 hour from
when the REGISTER call happens. You will need to register and
fetch a new token as you need it.
client_id: returned for informational purposes only
email: returned for informational purposes only
```
## Use the following endpoint to fetch posts:
* GET: https://api.supermetrics.com/assignment/posts
* PARAMS:
```
sl_token: Token from the register call
page: integer page number of posts (1-10)
```
* RETURNS:
```
page: What page was requested or retrieved
posts: 100 posts per page
```
