# Description
The exercise is to write a program which is adding name property into each leaf of given tree structure from `tree.json` file with name from `list.json` file. You should correlate structures through `category_id` from `list.json` and `Id` in `tree.json` .
The output should be similar to:

<pre>
[…{
“id”:19”, “name”:”Zdrowie i uroda”,”children”:[]},
...
]
</pre>

## Project setup
Requirements:
1. Docker version 20.10.3, build 48d30b5
1. docker-compose version 1.28.4, build cabd5cfb

Clone repository, `cd` inside, create `docker-compose.yml` file from template `docker-compose.yml.dist` (take comments inside under consideration) and run:
1. docker-compose build
1. docker-compose up -d
1. docker exec -it mint.php bash
1. composer install
1. ctrl+d

## Usage
Put your `tree` and `list` files in `app/files` directory and run commands:

1. docker exec -it mint.php bash
1. php src/run.php mint:one `path to tree file` `path to list file`
   
Or you can use example files:
<pre>
php src/run.php mint:one files/tree\ \(1\).json files/list\ \(1\).json 
</pre>

Output file saved in `files/output.json`. 

# PHPUnit
To execute tests run:
1. docker exec -it mint.php bash
1. ./vendor/bin/phpunit tests/
