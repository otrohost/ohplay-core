# What is this

OhPlay Core is the headless backend of OhPlay. It's based in the Laravel framework and can be manipulated through classic old fashioned REST API statements and some others cool tricks.

# Basic work flow

While OhPlay Core isn't a fully REST API per se, tries to pursue the enforcement of most of its guidelines. In that sense, we can find this as its basic work flow:

![](https://storage-otrohost.b-cdn.net/enterprise/OhPlay%20basic%20structure.jpeg)

# Database UML

![](https://storage-otrohost.b-cdn.net/enterprise/drawSQL-export-2021-01-22_17_27.png)

# Titles

## **Get all titles**

**GET /titles/** will retrieve all the available titles on the database.

### **Path parameteres**

|path |type| description| required | default
|-----|--------|-----|-----|-----|
|page |int|# of page | no| 1
|lang |string|language: es, en, pt| no| es


### **Example**

    GET https://api.ohplay.tv/api/titles/?page=1&lang=es

Will retrieve:

    {
      "status": "Success",
      "message": "Titles retrieved correctly.",
      "response": {
        "current_page": 1,
        "data": [
          {
            "id": 1,
            "title": "Juego de tronos",
            "cover_horizontal": "\/suopoADq0k8YZr4dQXcU6pToj6s.jpg",
            "cover_vertical": "\/mQ9cyw1gfpK1M3a69cgXFHvWkih.jpg"
          },
          {
            "id": 3,
            "title": "Los mundos de Coraline",
            "cover_horizontal": "\/8GHxjXlI5rqyTBuVNekGTPjG5T6.jpg",
            "cover_vertical": "\/805EGizPf6LnFVPGReaa44sBqJr.jpg"
          },
          {
            "id": 2,
            "title": "El laberinto del fauno",
            "cover_horizontal": "\/r77zeIxG8wdKzgNgDL0s2VexuMe.jpg",
            "cover_vertical": "\/53ZMT8Y18gwLpInzRLMEebAZxew.jpg"
          }
        ],
        "first_page_url": "http:\/\/135.181.196.30\/api\/titles?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http:\/\/135.181.196.30\/api\/titles?page=1",
        "links": [
          {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
          },
          {
            "url": "http:\/\/135.181.196.30\/api\/titles?page=1",
            "label": 1,
            "active": true
          },
          {
            "url": null,
            "label": "Next &raquo;",
            "active": false
          }
        ],
        "next_page_url": null,
        "path": "http:\/\/135.181.196.30\/api\/titles",
        "per_page": 15,
        "prev_page_url": null,
        "to": 3,
        "total": 3
      }
    }

## **Get titles by genre**

**GET /titles/{genre_id}** will retrieve all the available titles on the database of the {genre_id}.

### **Path parameteres**

|path |type| description| required | default
|-----|--------|-----|-----|-----|
|page |int|# of page | no| 1
|lang |string|language: es, en, pt| no| es

### **Example**

    GET https://api.ohplay.tv/api/titles/genre/1?page=1&lang=es

Will retrieve: 

    {
      "status": "Success",
      "message": "Titles of the choosed genre retrieved correctly.",
      "response": {
        "current_page": 1,
        "data": [
          {
            "id": 1,
            "title": "Game of Thrones",
            "genre": "Drama",
            "cover_horizontal": "\/suopoADq0k8YZr4dQXcU6pToj6s.jpg",
            "cover_vertical": "\/mQ9cyw1gfpK1M3a69cgXFHvWkih.jpg"
          },
          {
            "id": 2,
            "title": "Pan's Labyrinth",
            "genre": "Drama",
            "cover_horizontal": "\/r77zeIxG8wdKzgNgDL0s2VexuMe.jpg",
            "cover_vertical": "\/53ZMT8Y18gwLpInzRLMEebAZxew.jpg"
          }
        ],
        "first_page_url": "http:\/\/135.181.196.30\/api\/titles\/genre\/1?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http:\/\/135.181.196.30\/api\/titles\/genre\/1?page=1",
        "links": [
          {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
          },
          {
            "url": "http:\/\/135.181.196.30\/api\/titles\/genre\/1?page=1",
            "label": 1,
            "active": true
          },
          {
            "url": null,
            "label": "Next &raquo;",
            "active": false
          }
        ],
        "next_page_url": null,
        "path": "http:\/\/135.181.196.30\/api\/titles\/genre\/1",
        "per_page": 15,
        "prev_page_url": null,
        "to": 2,
        "total": 2
      }
    }

## **Get specific title**

**GET /titles/{title_id}** will retrieve title_id.

### **Path parameteres**

|path |type| description | required | default
|-----|--------|-----|-----|-----|
|lang |string|language: es, en, pt| no| es

### **Example**

    GET https://api.ohplay.tv/api/titles/3?lang=es
   
Will have as response: 

    {
      "status": "Success",
      "message": "Title retrieved correctly",
      "response": {
        "id": 3,
        "type": "movie",
        "title": "Los mundos de Coraline",
        "sinopsis": "Película de animación en la que se nos cuenta la historia de Coraline, una jovencita que descubre en su nueva casa una puerta secreta y decide abrirla. Al hacerlo, descubre una segunda versión de su vida, una vida paralela a la que ella tiene. A primera vista, la realidad paralela es curiosamente parecida a su vida de verdad, aunque mucho mejor. Pero cuando su increíble y maravillosa aventura empieza a tomar un cariz peligroso y su otra madre intenta mantenerla a su lado para siempre, Corali",
        "cover_vertical": "\/805EGizPf6LnFVPGReaa44sBqJr.jpg",
        "cover_horizontal": "\/8GHxjXlI5rqyTBuVNekGTPjG5T6.jpg",
        "TMDB": 14836,
        "genres": [
          {
            "genre_id": 5,
            "genre_title": "Animación"
          },
          {
            "genre_id": 6,
            "genre_title": "Familia"
          },
          {
            "genre_id": 3,
            "genre_title": "Fantasía"
          }
        ],
        "people": [],
        "contents": [
          {
            "content_id": 14,
            "content_uri": "https:\/\/cdn.ohplay.tv\/caroline.m3u8",
            "title": "Los mundos de Coraline",
            "sinopsis": "Película de animación en la que se nos cuenta la historia de Coraline, una jovencita que descubre en su nueva casa una puerta secreta y decide abrirla. Al hacerlo, descubre una segunda versión de su vida, una vida paralela a la que ella tiene. A primera vista, la realidad paralela es curiosamente parecida a su vida de verdad, aunque mucho mejor. Pero cuando su increíble y maravillosa aventura empieza a tomar un cariz peligroso y su otra madre intenta mantenerla a su lado para siempre, Corali",
            "contents_meta": []
          }
        ]
      }
    }

## **Search title**

**POST /titles/search** will search among all the titles.

### **Post parameteres**

|parameter |description |type| required 
|-----|--------|-----|-----
|query |search term |string| yes

### **Query parameteres**

|path |type| description| required | default
|-----|--------|-----|-----|-----|
|page |int|# of page | no| 1
|lang |string|language: es, en, pt| no| es
### **Example**

    POST https://api.ohplay.tv/api/titles/search?lang=es
    
    {
	    "query": "Game of thrones"
	}

WIll have as response:

    {
      "status": "Success",
      "message": "Titles found with match",
      "response": {
        "current_page": 1,
        "data": [
          {
            "id": 1,
            "title": "Juego de tronos",
            "cover_horizontal": "\/suopoADq0k8YZr4dQXcU6pToj6s.jpg",
            "cover_vertical": "\/mQ9cyw1gfpK1M3a69cgXFHvWkih.jpg"
          }
        ],
        "first_page_url": "http:\/\/135.181.196.30\/api\/titles\/search?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http:\/\/135.181.196.30\/api\/titles\/search?page=1",
        "links": [
          {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
          },
          {
            "url": "http:\/\/135.181.196.30\/api\/titles\/search?page=1",
            "label": 1,
            "active": true
          },
          {
            "url": null,
            "label": "Next &raquo;",
            "active": false
          }
        ],
        "next_page_url": null,
        "path": "http:\/\/135.181.196.30\/api\/titles\/search",
        "per_page": 15,
        "prev_page_url": null,
        "to": 1,
        "total": 1
      }
    }




## **Create title**

**POST /titles** will create a new title.

### **Post parameteres**

|parameter | description |type| required 
|-----|--------|-----|-----
|tmdb_id |TMDB of the title |int| yes
|type |movie/tv|string| yes

### **Example**

    POST https://api.ohplay.tv/api/titles
    
    {
		"tmdb_id": 1399,
		"type": "tv"
	}

Will create a new title in the database importing the info from the TV Show with ID 1399 in TMDB.

## **Delete title**

**DELETE /titles/{tmdb_id}** will delete the title related with tmdb_id and all its contents.

### **Example**

    DELETE https://api.ohplay.tv/api/titles/1399

Will delete the TV Show identified with the TMDB id 1399.

# Genres

## **Get all genres**

**GET /titles/genres/** will retrieve all the available genres on the database.

### **Path parameteres**

|path |type| description | required | default
|-----|--------|-----|-----|-----|
|lang |string| language: es, en, pt|no| es


### **Example**

    GET https://api.ohplay.tv/api/titles/genres?page=1&lang=es

Will retrieve:

    {
      "status": "Success",
      "message": "Genres retrieved correctly.",
      "response": [
        {
          "id": 1,
          "name": "Drama"
        },
        {
          "id": 2,
          "name": "Misterio"
        },
        {
          "id": 3,
          "name": "Crimen"
        },
        {
          "id": 4,
          "name": "Aventura"
        },
        {
          "id": 5,
          "name": "Acción"
        },
        {
          "id": 6,
          "name": "Ciencia ficción"
        },
        {
          "id": 7,
          "name": "Animación"
        },
        {
          "id": 8,
          "name": "Familia"
        },
        {
          "id": 9,
          "name": "Comedia"
        }
      ]
    }


# Contents

## **Create content**

**POST /titles/contents** will create a new content for a title.

### **Post parameteres**

|parameter |type |description|  required 
|-----|--------|----- |-----
|tmdb_id |int|TMDB_id of the title parent |yes
|source |string|The video source of the content |yes
|season |int|If a TV Show, the season of the content |Yes if the parent is a TV Show
|episode |int|If a TV Show, the season of the content |Yes if the parent is a TV Show
|other |any|Any other parameter will be added as meta|No

### **Example**

    POST https://api.ohplay.tv/api/titles/contents
    
    {
		"tmdb_id": 1399,
		"source": "source.m3u8",
		"season": 1,
		"episode": 1,
		"original_track": 0,
		"is_new": 1
	}

Will create a new episode for the TV Show 1399. It's important to highlight that the "original_track" and "is_new" values will be created as meta values of the content. 
