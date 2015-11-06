# Slot Machine Spin Results

## Design

- player.html simulates a request from the client side
- When a spin is completed on the client side, the client makes a hash from its salt value plus all the data fields (player id, coins won, coins bet)
- CryptoJS.SHA512 is used in this demo to generate the hash
- Client sends the hash with the data fields (player id, coins won, coins bet) to the server
- Update.php simulates a server end point that updates player data when a spin is completed on the client
- Server performs initial checks on the request
- If the initial check passes, the sever retrieves the player’s salt value from the database based on player id
- Server then tries to regenerate the hash using the retrieved salt value and received data (player id, coins won, coins bet)
- If the regenerated hash matches the received hash, the server updates the record

- Please see db.sql for database info

## Usage

1. Open player.html
2. Enter desired amount then click on “Send”
3. JSON response will be displayed

## Demo 

http://wyq.co/sg/player.html