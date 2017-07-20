# Tinwork API Pokemon

## Pokemons 
### Get all pokemons

* **URL:** /api/pokemons
* **Method:** GET
* **URL Params** : None
* **Data Params** : None
* **Success Response:** 
   * **Content:** `{"collection":{"code":200,"response":{"pokemons":[...]}}}`
* **Error Response:** 
   * **Content:** `{"collection":{"code":500 }`
* **Sample Call:** None
  
### Get pokemon

* **URL** : /api/pokemons/:id
* **Method:** GET
* **URL Params** : `id=[integer]`
* **Data Params** : None
* **Success Response:**
   * **Content:** `{ "collection" : {"code" : 200, "response" : { "pokemons" : [...] }}}`
* **Error Response:**
   * **Content:** `{ "collection" : {"code" : 500 }`
* **Sample Call:** None
 
### Save new pokemon
* **URL** : /admin/pokemons?token={{token}}
* **Method:** POST
* **URL Params** : None
* **Data Params** : 
    ```json
    {
      "body": {
        "name": "Bulbizarre",
        "type": [type_id_1, type_id_2],
        "rank": 1,
        "evolutions": {
          "sub_evolution": null,
          "post_evolution": [2, 3]
        }
      }
    }
    ```
* **Success Response:**
    **Content:** `{"collection":{"code" : 200 }`
* **Error Response:**
    **Content:** `{"collection":{"code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None

### Edit pokemon
* **URL** : /admin/pokemons/:id?token={{token}}
* **Method:** PUT | UPDATE
* **URL Params** : `id=[integer]`
* **Data Params** : 
    ```json
    {
      "body": {
        "name": "Bulbi"
      }
    }
    ```
* **Success Response:**
    **Content:** `{"collection":{"code" : 200 }`
* **Error Response:**
    **Content:** `{"collection":{"code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None

### Delete a pokemon
* **URL** : /admin/pokemons/:id?token={{token}}
* **Method:** DELETE
* **URL Params** : `id=[integer]`
* **Data Params** : None
* **Success Response:**
    **Content:** `{"collection":{"code" : 200 }`
* **Error Response:**
    **Content:** `{"collection":{"code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None


## Types
## Pokemon Geo
## Admins
