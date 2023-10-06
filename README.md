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

### PublicUser

```typescript
User = {
    id: Number,
    name: String,
    email: String,
    email_verified_at?: String,
    created_at: String,
    updated_at: String,
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

**Description**: Get user's bookmarks.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserBookmark[]`

### `api/account/comments`

**Description**: Get user's comments.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserComment[]`

### `api/account/grupos`

**Description**: Get user's grupos.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserGrupo[]`

### `api/account/password/link`

**Description**: Request password reset link.

**Methods**: POST

**RequestBody**: `{ email: User.email }`

**Response**: `{ success: Boolean }`

### `api/account/password/reset`

**Description**: Reset user's password.

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

**Response**: `{ success: Boolean }`

### `api/account/profile`

**Description**: Get account profile.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicUser`

### `api/account/profile`

**Description**: Update account profile.

**Methods**: POST

**RequestBody**: `PublicUser`

**Response**: `PublicUser`

### `api/account/verify/{id}/{hash}`

**Description**: Verify user's email.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `{ status: String }`

### `api/account/verify_link`

**Description**: Resend account verification link to user's email.

**Methods**: POST

**RequestBody**: `{ email: User.email }`

**Response**: `{ message: String }`

### `api/account/votes`

**Description**: Get user's votes.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserVote[]`

### `api/auth/login`

**Description**: Perform login.

**Methods**: POST

**RequestBody**: `{ email: User.email, password: User.password }`

**Response**: `{ token: String, user: PublicUser }`

### `api/auth/login/admin`

**Description**: Perform login as admin.

**Methods**: POST

**RequestBody**: `{ email: User.email, password: User.password }`

**Response**: `{ token: String, user: User }`

### `api/auth/logout`

**Description**: Perform logout.

**Methods**: POST

**RequestBody**: `None`

**Response**: `{ status: String }`

### `api/auth/register`

**Description**: Register public user account.

**Methods**: POST

**RequestBody**: `PublicUser`

**Response**: `PublicUser`

### `api/bookmark/{grupo}`

**Description**: Create bookmark.

**Methods**: POST

**RequestBody**: `None`

**Response**: `UserBookmark`

### `api/bookmark/{grupo}`

**Description**: Delete bookmark .

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `UserBookmark`

### `api/category`

**Description**: Get categories.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Category[]`

### `api/category`

**Description**: Create category.

**Methods**: POST

**RequestBody**: `Category`

**Response**: `Category`

### `api/category/{category}`

**Description**: Get category.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Category`:

### `api/category/{category}`

**Description**: Update category.

**Methods**: PUT, PATCH

**RequestBody**: `Category`

**Response**: `Category`:

### `api/category/{category}`

**Description**: Delete category.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Category`:

### `api/comment`

**Description**: Create comment.

**Methods**: POST

**RequestBody**: `Comment`

**Response**: `Comment`

### `api/comment/{comment}`

**Description**: Delete comment.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Comment`

### `api/grupo`

**Description**: Get grupos.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Grupo[]`

### `api/grupo`

**Description**: Create grupo.

**Methods**: POST

**RequestBody**: `Grupo`

**Response**: `Grupo`

### `api/grupo/{grupo}`

**Description**: Get grupo.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Grupo`

### `api/grupo/{grupo}`

**Description**: Update grupo.

**Methods**: PUT, PATCH

**RequestBody**: `Grupo`

**Response**: `Grupo`

### `api/grupo/{grupo}`

**Description**: Delete grupo.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Grupo`

### `api/permission`

**Description**: Get permissions.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Permission.name[]`

### `api/public/categorias`

**Description**: Get public categories.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Category.name[]`

### `api/public/grupos`

**Description**: Get public grupos.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicGrupo[]`

### `api/public/grupos/{grupo}`

**Description**: Get public grupo.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicGrupo`

### `api/public/tags`

**Description**: Get public tags.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicTags`

### `api/role`

**Description**: Get roles.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Role[]`

### `api/role`

**Description**: Create role.

**Methods**: POST

**RequestBody**: `Role`

**Response**: `Role`

### `api/role/{role}`

**Description**: Get role.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Role`

### `api/role/{role}`

**Description**: Update role.

**Methods**: PUT, PATCH

**RequestBody**: `Role`

**Response**: `Role`

### `api/role/{role}`

**Description**: Delete role.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Role`

### `api/tag`

**Description**: Get tags.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Tag[]`

### `api/tag`

**Description**: Create tag.

**Methods**: POST

**RequestBody**: `Tag`

**Response**: `Tag`

### `api/tag/{tag}`

**Description**: Get tag.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Tag`

### `api/tag/{tag}`

**Description**: Update tag.

**Methods**: PUT, PATCH

**RequestBody**: `Tag`

**Response**: `Tag`

### `api/tag/{tag}`

**Description**: Delete tag.

**Methods**: DELETE

**RequestBody**: `Tag`

**Response**: `Tag`

### `api/user`

**Description**: Get users.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `User[]`

### `api/user`

**Description**: Create user.

**Methods**: POST

**RequestBody**: `User`

**Response**: `User`

### `api/user/{user}`

**Description**: Get user.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `User`

### `api/user/{user}`

**Description**: Update user.

**Methods**: PUT, PATCH

**RequestBody**: `User`

**Response**: `User`

### `api/user/{user}`

**Description**: Delete user.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `User`

### `api/vote`

**Description**: Create vote.

**Methods**: POST

**RequestBody**: `Vote`

**Response**: `Vote`

### `api/vote/{vote}`

**Description**: Update vote.

**Methods**: PUT, PATCH

**RequestBody**: `Vote`

**Response**: `Vote`

### `api/vote/{vote}`

**Description**: Delete vote.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Vote`

### `sanctum/csrf-cookie`

**Description**: Get CSRF cookie.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `None`

**ResponseHeaders**:

```
Set-Cookie: XSRF-TOKEN=${CSRF_TOKEN}
Set-Cookie: grusp_api_session=${SESSION_TOKEN}
```