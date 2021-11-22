# Abnormal behavior of relations during tests
using liip/test-fixtures-bundle and hautelook/alice-bundle

## Abnormal behavior:
I have 2 entities Board and Lane that have a OneToMany relationship.
Everything works normally with the entities loaded from the database.
However, I had problems with my tests if I load the fixtures before, the collections are empty when they should contain data.

To demonstrate the bug I started from the [Symfony Docker](https://github.com/dunglas/symfony-docker) to make it easier to reproduce the bug.
I removed caddy and postgres since they are not necessary to see the bug.

There is a Makefile, so to see the bug, you can do :

```make dev-up```

```make test```