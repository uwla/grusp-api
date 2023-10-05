# GRUSP API

Backend for GRUSP.

Built with [Laravel 10](https://laravel.com/docs/10.x/).

## Data

Using typescript syntax, we define some data types and their corresponding JSON which is returned by the API.

### PublicImage

```typescript
PublicImage = String
```

### PublicComment

```typescript
PublicComment = {
    "comment": String,
    "created_at": String,
    "updated_at": String,
    "author": String,
}
```

### PublicTag

```typescript
PublicTag = String
```

### PublicCategory

```typescript
PublicCategory = String
```

### PublicCategories

```typescript
PublicCategorizedTags = {
    [key: PublicCategory]: PublicTag
}
```

### PublicGrupo

```typescript
PublicGrupo = {
    "id": Number,
    "titulo": String,
    "descricao": String,
    "contato": String,
    "horario": String,
    "links": String,
    "lugar": String,
    "mensalidade": String,
    "publico": String,
    "created_at": String,
    "updated_at": String,
    "upvotes": Number,
    "downvotes": Number,
    "img": PublicImage,
    "images": PublicImage[],
    "comments": PublicComment[],
    "tags": PublicTag[]
}
```

### User

```typescript
User = {
    "id": Number,
    "name": String,
    "email": String,
    "email_verified_at": String,
    "created_at": String,
    "updated_at": String,
    "roles": Role.name[]
}
```

### Role

```typescript
Role = {
    "id": Number,
    "name": String,
    "description": String,
    "created_at": String,
    "updated_at": String,
    "permissions": Permission[]
}
```

### Permission

```typescript
Permission = String
```

### User Votes

## Routes

The following routes are defined

| Method         | URL                              | Name                     | Action                                    |
| ---------      | ------------------------------   | -------------------      | ---------------------------------------   |
| `GET`, `HEAD`  | `api/account/bookmarks`          | `account.bookmarks`      | `AccountController@bookmarks`             |
| `GET`, `HEAD`  | `api/account/comments`           | `account.comments`       | `AccountController@comments`              |
| `GET`, `HEAD`  | `api/account/grupos`             | `account.grupos`         | `AccountController@grupos`                |
| `POST`         | `api/account/password/link`      | `password.email`         | `AccountController@sendResetLinkEmail`    |
| `POST`         | `api/account/password/reset`     | `password.reset`         | `AccountController@resetPassword`         |
| `GET`, `HEAD`  | `api/account/profile`            | `account.profile`        | `AccountController@getProfile`            |
| `POST`         | `api/account/profile`            | `account.profile-update` | `AccountController@updateProfile`         |
| `GET`, `HEAD`  | `api/account/verify/{id}/{hash}` | `verification.verify`    | `AccountController@verifyEmail`           |
| `POST`         | `api/account/verify_link`        | `verification.link`      | `AccountController@sendVerificationEmail` |
| `GET`, `HEAD`  | `api/account/votes`              | `account.votes`          | `AccountController@votes`                 |
| `POST`         | `api/auth/login`                 | `login`                  | `AuthController@login`                    |
| `POST`         | `api/auth/login/admin`           | `login-admin`            | `AuthController@loginAdmin`               |
| `POST`         | `api/auth/logout`                | `logout`                 | `AuthController@logout`                   |
| `POST`         | `api/auth/register`              | `register`               | `AuthController@register`                 |
| `POST`         | `api/bookmark/{grupo}`           | `bookmark.store`         | `BookmarkController@store`                |
| `DELETE`       | `api/bookmark/{grupo}`           | `bookmark.delete`        | `BookmarkController@destroy`              |
| `GET`, `HEAD`  | `api/category`                   | `category.index`         | `CategoryController@index`                |
| `POST`         | `api/category`                   | `category.store`         | `CategoryController@store`                |
| `GET`, `HEAD`  | `api/category/{category}`        | `category.show`          | `CategoryController@show`                 |
| `PUT`, `PATCH` | `api/category/{category}`        | `category.update`        | `CategoryController@update`               |
| `DELETE`       | `api/category/{category}`        | `category.destroy`       | `CategoryController@destroy`              |
| `POST`         | `api/comment`                    | `comment.store`          | `CommentController@store`                 |
| `PUT`, `PATCH` | `api/comment/{comment}`          | `comment.update`         | `CommentController@update`                |
| `DELETE`       | `api/comment/{comment}`          | `comment.destroy`        | `CommentController@destroy`               |
| `GET`, `HEAD`  | `api/grupo`                      | `grupo.index`            | `GrupoController@index`                   |
| `POST`         | `api/grupo`                      | `grupo.store`            | `GrupoController@store`                   |
| `GET`, `HEAD`  | `api/grupo/{grupo}`              | `grupo.show`             | `GrupoController@show`                    |
| `PUT`, `PATCH` | `api/grupo/{grupo}`              | `grupo.update`           | `GrupoController@update`                  |
| `DELETE`       | `api/grupo/{grupo}`              | `grupo.destroy`          | `GrupoController@destroy`                 |
| `GET`, `HEAD`  | `api/permission`                 | `permission.index`       | `PermissionController@index`              |
| `GET`, `HEAD`  | `api/public/categorias`          | `public.category`        | `PublicController@categories`             |
| `GET`, `HEAD`  | `api/public/grupos`              | `public.grupo.index`     | `PublicController@grupos`                 |
| `GET`, `HEAD`  | `api/public/grupos/{grupo}`      | `public.grupo.show`      | `PublicController@grupo`                  |
| `GET`, `HEAD`  | `api/public/tags`                | `public.tag`             | `PublicController@tags`                   |
| `GET`, `HEAD`  | `api/role`                       | `role.index`             | `RoleController@index`                    |
| `POST`         | `api/role`                       | `role.store`             | `RoleController@store`                    |
| `GET`, `HEAD`  | `api/role/{role}`                | `role.show`              | `RoleController@show`                     |
| `PUT`, `PATCH` | `api/role/{role}`                | `role.update`            | `RoleController@update`                   |
| `DELETE`       | `api/role/{role}`                | `role.destroy`           | `RoleController@destroy`                  |
| `GET`, `HEAD`  | `api/tag`                        | `tag.index`              | `TagController@index`                     |
| `POST`         | `api/tag`                        | `tag.store`              | `TagController@store`                     |
| `GET`, `HEAD`  | `api/tag/{tag}`                  | `tag.show`               | `TagController@show`                      |
| `PUT`, `PATCH` | `api/tag/{tag}`                  | `tag.update`             | `TagController@update`                    |
| `DELETE`       | `api/tag/{tag}`                  | `tag.destroy`            | `TagController@destroy`                   |
| `GET`, `HEAD`  | `api/user`                       | `user.index`             | `UserController@index`                    |
| `POST`         | `api/user`                       | `user.store`             | `UserController@store`                    |
| `GET`, `HEAD`  | `api/user/{user}`                | `user.show`              | `UserController@show`                     |
| `PUT`, `PATCH` | `api/user/{user}`                | `user.update`            | `UserController@update`                   |
| `DELETE`       | `api/user/{user}`                | `user.destroy`           | `UserController@destroy`                  |
| `POST`         | `api/vote`                       | `vote.store`             | `VoteController@store`                    |
| `PUT`, `PATCH` | `api/vote/{vote}`                | `vote.update`            | `VoteController@update`                   |
| `DELETE`       | `api/vote/{vote}`                | `vote.destroy`           | `VoteController@destroy`                  |
| `GET`, `HEAD`  | `sanctum/csrf-cookie`            | `sanctum.csrf-cookie`    | `CsrfCookieController@show`               |

### `api/account/bookmarks`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/account/comments`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/account/grupos`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/account/password/link`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/account/password/reset`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/account/profile`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/account/profile`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/account/verify/{id}/{hash}`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/account/verify_link`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/account/votes`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/auth/login`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/auth/login/admin`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/auth/logout`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/auth/register`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/bookmark/{grupo}`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/bookmark/{grupo}`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/category`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/category`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/category/{category}`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/category/{category}`

**Description**:

**Methods**: PUT, PATCH

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/category/{category}`

**Description**:

**Methods**: DELETE

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/comment`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/comment/{comment}`

**Description**:

**Methods**: PUT, PATCH

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/comment/{comment}`

**Description**:

**Methods**: DELETE

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/grupo`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/grupo`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/grupo/{grupo}`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/grupo/{grupo}`

**Description**:

**Methods**: PUT, PATCH

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/grupo/{grupo}`

**Description**:

**Methods**: DELETE

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/permission`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/public/categorias`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/public/grupos`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/public/grupos/{grupo}`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/public/t`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/role`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/role`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/role/{role}`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/role/{role}`

**Description**:

**Methods**: PUT, PATCH

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/role/{role}`

**Description**:

**Methods**: DELETE

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/tag`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/tag`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/tag/{tag}`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/tag/{tag}`

**Description**:

**Methods**: PUT, PATCH

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/tag/{tag}`

**Description**:

**Methods**: DELETE

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/user`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/user`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/user/{user}`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/user/{user}`

**Description**:

**Methods**: PUT, PATCH

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/user/{user}`

**Description**:

**Methods**: DELETE

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/vote`

**Description**:

**Methods**: POST

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/vote/{vote}`

**Description**:

**Methods**: PUT, PATCH

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `api/vote/{vote}`

**Description**:

**Methods**: DELETE

**Params**:

```json
{}
```

**Output**:

```json
{}
```

### `sanctum/csrf-cookie`

**Description**:

**Methods**: GET, HEAD

**Params**:

```json
{}
```

**Output**:

```json
{}
```