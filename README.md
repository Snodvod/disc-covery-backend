# Disc Covery

## API endpoints
### Messages
| Method	| URL								| Function							|
| --------- | --------------------------------- | --------------------------------- |
| GET		| messages/feed						| Get the user's newsfeed			|
| POST		| messages/listening/{*record_id*}	| Make a new "Listening To" post	|

### Records
| Method	| URL								| Function																		|
| --------- | --------------------------------- | ----------------------------------------------------------------------------- |
| GET		| records/get/{user_id?}			| Gets all the user's records (defaults to logged in user						|
| GET		| records/{record_id}/get			| Get the record data															|
| GET		| record/{record_id}/find			| Finds someone you're following who owns this record							|

### Users
| Method	| URL								| Function																		|
| --------- | --------------------------------- | ----------------------------------------------------------------------------- |
| GET		| following/get/					| get all your subscriptions													|
| GET		| users/{user_id}/follow			| Start following a certain user												|
| GET		| users/{user_id}/unfollow			| Stop following a certain user													|
