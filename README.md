# GRUSP API

Backend for GRUSP.

Built with [Laravel 10](https://laravel.com/docs/10.x/).

## Data

Using typescript syntax, we define some data types.

Their corresponding JSON is returned by the API.

### Permission

```typescript
Permission = {
    id: Number,
    name: String,
    model?: String,
    model_id?: String,
    description?: String,
    created_at: String,
    updated_at: String,
}
```

### Role

```typescript
Role = {
    id: Number,
    name: String,
    description?: String,
    created_at: String,
    updated_at: String,
    permissions: Permission.name[]
}
```

### User

```typescript
User = {
    id: Number,
    name: String,
    email: String,
    email_verified_at?: String,
    created_at: String,
    updated_at: String,
    roles: Role.name[]
}
```

### Category

```typescript
Category = {
    id: Number,
    name: String,
    namespace?: String,
    description?: String,
    created_at: String,
    updated_at: String,
}
```

### Tag

```typescript
Tag = {
    id: Number,
    name: String,
    namespace?: String,
    description?: String,
    created_at: String,
    updated_at: String,
    category: Category.name,
}
```

### Image

```typescript
Image = {
    id: Number,
    url: String,
}
```

### Vote

```typescript
Boolean = {
    id: Number,
    user_id: Number,
    grupo_id: Number,
    vote: Boolean,
}
```

### Comment

```typescript
Comment = {
    id: Number,
    user_id: Number,
    grupo_id: Number,
    comment: String,
    created_at: String,
    updated_at: String,
}
```


### GrupoComment

```typescript
GrupoComment = {
    id: Number,
    author: String,
    comment: String,
    created_at: String,
    updated_at: String,
}
```

### Grupo

```typescript
Grupo = {
    id: Number,
    titulo: String,
    descricao: String,
    contato?: String,
    horario?: String,
    links?: String,
    lugar?: String,
    mensalidade?: String,
    publico?: String,
    created_at: String,
    updated_at: String,
    upvotes: Number,
    downvotes: Number,
    img: Image,
    images: Image[],
    comments: GroupComment[],
    tags: Tag.name[]
}
```

### PublicGrupo

```typescript
PublicGrupo = {
    id: Number,
    titulo: String,
    descricao: String,
    contato?: String,
    horario?: String,
    links?: String,
    lugar?: String,
    mensalidade?: String,
    publico?: String,
    created_at: String,
    updated_at: String,
    upvotes: Number,
    downvotes: Number,
    img: Image.url,
    images: Image.url[],
    comments: GrupoComment[],
    tags: Tag.name[]
}
```

### PublicTags

```typescript
PublicTags = {
    [key: Category.name]: Tag.name[],
}
```

### UserGrupo

```typescript
UserGrupo = Grupo
```

### UserBookmark

```typescript
UserBookmark = Grupo.id
```

### UserVote

```typescript
UserVote = {
    id: Number,
    vote: Boolean,
    grupo_id: Number,
}
```

### UserComment

```typescript
UserComment = {
    id: Number,
    group_id: String,
    comment: String,
    created_at: String,
    updated_at: String,
}
```

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

**RequestBody**: `None`

**Response**: `UserBookmark[]`

### `api/account/comments`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserComment[]`

### `api/account/grupos`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserGrupo[]`

### `api/account/password/link`

**Description**:

**Methods**: POST

**RequestBody**:

```typescript
{
    email: User.email
}
```

**Response**:

```typescript
{
    success: Boolean
}
```

### `api/account/password/reset`

**Description**:

**Methods**: POST

**RequestBody**:

```typescript
{
    token: String,
    email: User.email,
    password: User.password,
    password_confirmation: User.password,
}
```

**Response**:

```typescript
{
    success: Boolean
}
```

### `api/account/profile`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `User`

### `api/account/profile`

**Description**:

**Methods**: POST

**RequestBody**: `User`

**Response**: `User`

### `api/account/verify/{id}/{hash}`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**:

```typescript
{
    status: String,
}
```

### `api/account/verify_link`

**Description**:

**Methods**: POST

**RequestBody**:

```typescript
{
    email: User.email
}
```

**Response**:

```typescript
{
    message: String,
}
```

### `api/account/votes`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserVote[]`

### `api/auth/login`

**Description**:

**Methods**: POST

**RequestBody**:

```typescript
{
    email: User.email,
    password: User.password,
}
```

**Response**:

```typescript
{
    token: String,
    user: User,
}
```

### `api/auth/login/admin`

**Description**:

**Methods**: POST

**RequestBody**:

```typescript
{
    email: User.email,
    password: User.password,
}
```

**Response**:

```typescript
{
    token: String,
    user: User,
}
```

### `api/auth/logout`

**Description**:

**Methods**: POST

**RequestBody**: `None`

**Response**:

```typescript
{
    status: String
}
```

### `api/auth/register`

**Description**:

**Methods**: POST

**RequestBody**: `User`

**Response**: `User`

### `api/bookmark/{grupo}`

**Description**:

**Methods**: POST

**RequestBody**: `None`

**Response**: `UserBookmark`

### `api/bookmark/{grupo}`

**Description**:

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `UserBookmark`

### `api/category`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Category[]`

### `api/category`

**Description**:

**Methods**: POST

**RequestBody**: `Category`

**Response**: `Category`

### `api/category/{category}`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Category`:

### `api/category/{category}`

**Description**:

**Methods**: PUT, PATCH

**RequestBody**: `Category`

**Response**: `Category`:

### `api/category/{category}`

**Description**:

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Category`:

### `api/comment`

**Description**:

**Methods**: POST

**RequestBody**: `Comment`

**Response**: `Comment`

### `api/comment/{comment}`

**Description**:

**Methods**: PUT, PATCH

**RequestBody**: `Comment`

**Response**: `Comment`

### `api/comment/{comment}`

**Description**:

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Comment`

### `api/grupo`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Grupo[]`

### `api/grupo`

**Description**:

**Methods**: POST

**RequestBody**: `Grupo`

**Response**: `Grupo`

### `api/grupo/{grupo}`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Grupo`

### `api/grupo/{grupo}`

**Description**:

**Methods**: PUT, PATCH

**RequestBody**: `Grupo`

**Response**: `Grupo`

### `api/grupo/{grupo}`

**Description**:

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Grupo`

### `api/permission`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Permission.name[]`

### `api/public/categorias`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Category.name[]`

### `api/public/grupos`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicGrupo[]`

### `api/public/grupos/{grupo}`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicGrupo`

### `api/public/tags`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicTags`

### `api/role`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Role[]`

### `api/role`

**Description**:

**Methods**: POST

**RequestBody**: `Role`

**Response**: `Role`

### `api/role/{role}`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Role`

### `api/role/{role}`

**Description**:

**Methods**: PUT, PATCH

**RequestBody**: `Role`

**Response**: `Role`

### `api/role/{role}`

**Description**:

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Role`

### `api/tag`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Tag[]`

### `api/tag`

**Description**:

**Methods**: POST

**RequestBody**: `Tag`

**Response**: `Tag`

### `api/tag/{tag}`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Tag`

### `api/tag/{tag}`

**Description**:

**Methods**: PUT, PATCH

**RequestBody**: `Tag`

**Response**: `Tag`

### `api/tag/{tag}`

**Description**:

**Methods**: DELETE

**RequestBody**: `Tag`

**Response**: `Tag`

### `api/user`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `User[]`

### `api/user`

**Description**:

**Methods**: POST

**RequestBody**: `User`

**Response**: `User`

### `api/user/{user}`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `User`

### `api/user/{user}`

**Description**:

**Methods**: PUT, PATCH

**RequestBody**: `User`

**Response**: `User`

### `api/user/{user}`

**Description**:

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `User`

### `api/vote`

**Description**:

**Methods**: POST

**RequestBody**: `Vote`

**Response**: `Vote`

### `api/vote/{vote}`

**Description**:

**Methods**: PUT, PATCH

**RequestBody**: `Vote`

**Response**: `Vote`

### `api/vote/{vote}`

**Description**:

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Vote`

### `sanctum/csrf-cookie`

**Description**:

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `None`

**ResponseHeaders**:

```
Set-Cookie: XSRF-TOKEN=${CSRF_TOKEN}
Set-Cookie: grusp_api_session=${SESSION_TOKEN}
```