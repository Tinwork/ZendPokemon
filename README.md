# Tinwork API Pokemon

## Access Token
### Get token
* **URL:** /admin/oauth
* **Method:** POST
* **URL Params** : None
* **Data Params** : 
  * [username] : root
  * [password] : root
* **Success Response:** 
   * **Content:** `{ "collection" : { "code" : 200, "response" : { "token" : "token" }}}`
* **Error Response:** 
   * **Content:** `{ "collection" : { "code" : 500 }`
* **Sample Call:** None

## Pokemons 
### Get all pokemons
* **URL:** /api/pokemons
* **Method:** GET
* **URL Params** : None
* **Data Params** : None
* **Success Response:** 
   * **Content:** `{ "collection" : { "code" : 200, "response" : { "pokemons" : [...] }}}`
* **Error Response:** 
   * **Content:** `{ "collection" : { "code" : 500 }`
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
* **URL Params** : `token=[string]`
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
  * **Content:** `{ "collection" : { "code" : 200 }`
* **Error Response:**
  * **Content:** `{ "collection" : { "code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None

### Edit pokemon
* **URL** : /admin/pokemons/:id?token={{token}}
* **Method:** PUT | UPDATE
* **URL Params** :
  * `id=[integer]`
  * `token=[string]`
* **Data Params** : 
    ```json
    {
      "body": {
        "name": "Bulbi"
      }
    }
    ```
* **Success Response:**
  * **Content:** `{ "collection" : { "code" : 200 }`
* **Error Response:**
  * **Content:** `{ "collection" : { "code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None

### Delete a pokemon
* **URL** : /admin/pokemons/:id?token={{token}}
* **Method:** DELETE
* **URL Params** :
  * `id=[integer]`
  * `token=[string]`
* **Data Params** : None
* **Success Response:**
  * **Content:** `{ "collection" : { "code" : 200 }`
* **Error Response:**
  * **Content:** `{ "collection" : { "code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None

## Types
### Get all types

* **URL:** /api/types
* **Method:** GET
* **URL Params** : None
* **Data Params** : None
* **Success Response:** 
   * **Content:** `{ "collection" : { "code" : 200, "response" : { "types" : [...] }}}`
* **Error Response:** 
   * **Content:** `{ "collection" : { "code" : 500 }`
* **Sample Call:** None
  
### Get all types badges

* **URL:** /api/types/badges
* **Method:** GET
* **URL Params** : None
* **Data Params** : None
* **Success Response:** 
   * **Content:** `{ "collection" : {"code" : 200, "response": [...] }}`
* **Error Response:** 
   * **Content:** `{ "collection" : {"code" : 500 }`
* **Sample Call:** None
  
### Get type 

* **URL** : /api/types/:id
* **Method:** GET
* **URL Params** : `id=[integer]`
* **Data Params** : None
* **Success Response:**
   * **Content:** `{ "collection" : {"code" : 200, "response" : { "types" : [...] }}}`
* **Error Response:**
   * **Content:** `{ "collection" : {"code" : 500 }`
* **Sample Call:** None
 
### Get pokemons from type 

* **URL** : /api/types/:id/pokemons
* **Method:** GET
* **URL Params** : `id=[integer]`
* **Data Params** : None
* **Success Response:**
   * **Content:** `{ "collection" : { "code" : 200, "response" : { "type" : [], "pokemons" : [] }}}`
* **Error Response:**
   * **Content:** `{ "collection" : { "code" : 500 }`
* **Sample Call:** None
 
### Save new types
* **URL** : /admin/types?token={{token}}
* **Method:** POST
* **URL Params** : `token=[string]`
* **Data Params** : 
    ```json
    {
      "body": {
        "label": "Poison",
        "color" : "#B55AA5",
        "badge" : "http://52.208.132.215/img/badges/poison.png"
      }
    }
    ```
* **Success Response:**
  * **Content:** `{"collection":{"code" : 200 }`
* **Error Response:**
  * **Content:** `{"collection":{"code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None

### Edit types
* **URL** : /admin/types/:id?token={{token}}
* **Method:** PUT | UPDATE
* **URL Params** :
  * `id=[integer]`
  * `token=[string]`
* **Data Params** : 
    ```json
    {
      "body": {
          "label": "Planteuh"	
        }
    }
    ```
* **Success Response:**
  * **Content:** `{"collection":{"code" : 200 }`
* **Error Response:**
  * **Content:** `{"collection":{"code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None

### Delete a type
* **URL** : /admin/types/:id?token={{token}}
* **Method:** DELETE
* **URL Params** : 
  * `id=[integer]`
  * `token=[string]`
* **Data Params** : None
* **Success Response:**
  * **Content:** `{"collection":{"code" : 200 }`
* **Error Response:**
  * **Content:** `{"collection":{"code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None

## Pokemon Geo
### Get all pokemons positions
* **URL** : /api/geo/pokemons?long=11&lat=11&r=2
* **Method:** GET
* **URL Params** : 
  * `long=[float]` 
  * `lat=[float]` 
  * `r=[integer]`
* **Data Params** : None
* **Success Response:**
   * **Content:** 
   ```json
   {
      "code": 200,
      "response": {
          "result": {
              "radar": {
                  "longitude": 48.8246,
                  "latitude": 2.56619
              },
              "result": 3,
              "collection": [ ... ]
          }
      }
    }
   ```
* **Error Response:**
   * **Content:** `{ "collection" : { "code" : 500 }`
* **Sample Call:** None

### Get pokemon position
* **URL** : /api/geo/pokemons/:id?long=11&lat=11&r=2
* **Method:** GET
* **URL Params** : 
  * `id=[integer]` 
  * `long=[float]` 
  * `lat=[float]` 
  * `r=[integer]`
* **Data Params** : None
* **Success Response:**
   * **Content:** 
   ```json
   {
      "code": 200,
      "response": {
          "result": {
              "radar": {
                  "longitude": 48.8246,
                  "latitude": 2.56619
              },
              "result": 3,
              "collection": [ ... ]
          }
      }
    }
   ```
* **Error Response:**
   * **Content:** `{ "collection" : { "code" : 500 }`
* **Sample Call:** None

### Add new position to a pokemon
* **URL** : /api/geo/pokemons/:id
* **Method:** POST
* **URL Params** : `id=[integer]`
* **Data Params** : 
   ```json
   {
     "body": {
        "longitude": 35.323,
        "latitude" : 42.233
     }
   }
   ```
* **Success Response:**
  * **Content:** `{"collection":{"code" : 200 }`
* **Error Response:**
  * **Content:** `{"collection":{"code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None

## Admins
### Add new admin
* **URL** : /admin?token=:token
* **Method:** POST
* **URL Params** : `token=[string]`
* **Data Params** : 
   ```json
   {
      "body": {
        "pseudo": "root",
        "password": "root",
        "roles" : ["SUPER"]
      }
    }
   ```
* **Success Response:**
  * **Content:** `{"collection":{"code" : 200 }`
* **Error Response:**
  * **Content:** `{"collection":{"code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None

### Delete admin
* **URL** : /admin/:id?token=:token
* **Method:** POST
* **URL Params** : 
  * `id=[integer]` 
  * `token=[string]`
* **Data Params** : None 
* **Success Response:**
  * **Content:** `{"collection":{"code" : 200 }`
* **Error Response:**
  * **Content:** `{"collection":{"code" : 500, "errors" : [ ... ] }`
* **Sample Call:** None
