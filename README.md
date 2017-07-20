# Tinwork API Pokemon

## Pokemons 
### Get all pokemons
----
Returns json data about all pokemons.
* **URL:** /api/pokemons
* **Method:** GET
* **URL Params** : None
* **Data Params** : None
* **Success Response:** `{"collection":{"code":200,"response":{"pokemons":[...]}}}`
* **Error Response:** `{"collection":{"code":500 }`
* **Sample Call:** None
  
  
### Get pokemon
Returns json data about one pokemon.
* **URL** : /api/pokemons/:id
* **Method:** GET
* **URL Params** : `id=[integer]`
* **Data Params** : None
* **Success Response:**
    **Content:** `{"collection":{"code":200,"response":{"pokemons":[...]}}}`
* **Error Response:**
    **Content:** `{"collection":{"code":500 }`
* **Sample Call:** None
 
 
###Save new pokemon
##Types
##Pokemon Geo
##Admins
