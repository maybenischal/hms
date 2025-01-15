# DBAL

Tiny database abstraction layer for [MongoDB](http://www.mongodb.org/) (on top of [doctrine/mongodb](https://github.com/doctrine/mongodb)) and relational databases (on top of [doctrine/dbal](https://github.com/doctrine/dbal)).

It provides a non-POPO base model class and [Identity Mapping](https://en.wikipedia.org/wiki/Identity_map_pattern) repository classes for both MongoDB and relational databases.

The goal of this project is to provide a semi-low-level database abstraction layer.
[Doctrine MongoDB ODM](http://docs.doctrine-project.org/projects/doctrine-mongodb-odm/en/latest/) and the [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html) have you covered if you need more "magic".
