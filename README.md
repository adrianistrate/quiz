## Quiz

### Techs:

- Symfony4.4
- Bootstrap4
- jQuery3
- MySQL5.7

### Instalation

After cloning run:

```bash
$ symfony composer install
```

Create a database, edit **.env** then run:

```bash
$ symfony console doctrine:schema:update --force
```

```bash
$ symfony console doctrine:fixtures:load --env=dev
```

```bash
$ yarn install
```

```bash
$ yarn encore prod
```

### Admin

Use **admin** / **admin**