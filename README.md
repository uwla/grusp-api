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

## ACL

GRUSP Api uses an Acess Control List system to manage resource  actions.  It  is
based on a role-permission paradigm, where roles have permissions and users have
roles.

Permissions grant access to specific or generic resources. A generic  permission
is one that allows an action to be performed on several instances of a model.  A
specific permission allows an action to be performed on a particular instance of
a model.

Example of generic permissions: `{model}.create`, `{model}.viewAny`,
`{model}.updateAny`, `{model}.deleteAny`. Here `{m̀odel}` denotes the model's
slug, such as `user`, `grupo`, `tag`, `role`, etc.

Example of specific permissions: `{model}.view`, `{model}.update`,
`{model}.delete`. These specific permissions are associated with the ID of the
model instance they represent.

Permissiosn  can't  be  created,  not  even  by  administrator.  They  are   all
predefined. Only specific permissions are created, but these are created by  the
API itself, such as when a user creates a grupo and permissions related  to  the
grupo are created as well.

Users inherit permissions from their roles, which are abstract entities used  to
group permissions related to a particular  administrative  function.  Users  may
also have direct permissions,  instead  of  inheriting  from  their  roles.  One
example of direct permissions is the permission to visualize, modify, and delete
grupos created by the user himself.

There are administrative roles: admin (all permissions) and manager  (all  Grupo
related permissions). There is also non-administrative roles: normal  user  (can
create grupos and edit his own). All users registered by public registration are
normal users. Users added by the administrator will have their roles set by  the
administrator.


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


Next, we describe each route.

The Authentication field specifies the authentication required to make the API
call. The value `logged in` means the user should be logged in. The value `not logged`
means the user does not need to be logged in. Other methods include an
authentication `token` in the request's body.

The Authorization field specifies which permissions are required to make the API
call. If the user making the request has any of the specificed  permissions,  he
is authorized; otherwise, he is not. Empty permissions means that  there  is  no
specific permission requirements (though login may be required).

### `api/account/bookmarks`

**Description**: Get user's bookmarks.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserBookmark[]`

**Authentication**: logged in

**Authorization**: `[]`

### `api/account/comments`

**Description**: Get user's comments.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserComment[]`

**Authentication**: logged in

**Authorization**: `[]`

### `api/account/grupos`

**Description**: Get user's grupos.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserGrupo[]`

**Authentication**: logged in

**Authorization**: `[]`

### `api/account/password/link`

**Description**: Request password reset link.

**Methods**: POST

**RequestBody**: `{ email: User.email }`

**Response**: `{ success: Boolean }`

**Authentication**: not logged

**Authorization**: `[]`

### `api/account/password/reset`

**Description**: Reset user's password.

**Methods**: POST

**RequestBody**: `{ token: String, email: User.email, password: User.password, password_confirmation: User.password, }`

**Response**: `{ success: Boolean }`

**Authentication**: via request token

**Authorization**: `[]`

### `api/account/profile`

**Description**: Get account profile.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicUser`

**Authentication**: logged in

**Authorization**: `[]`

### `api/account/profile`

**Description**: Update account profile.

**Methods**: POST

**RequestBody**: `PublicUser`

**Response**: `PublicUser`

**Authentication**: logged in

**Authorization**: `[]`

### `api/account/verify/{id}/{hash}`

**Description**: Verify user's email.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `{ status: String }`

**Authentication**: via hash signature

**Authorization**: `[]`

### `api/account/verify_link`

**Description**: Resend account verification link to user's email.

**Methods**: POST

**RequestBody**: `{ email: User.email }`

**Response**: `{ message: String }`

**Authentication**: not logged

**Authorization**: `[]`

### `api/account/votes`

**Description**: Get user's votes.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `UserVote[]`

**Authentication**: logged in

**Authorization**: `[]`

### `api/auth/login`

**Description**: Perform login.

**Methods**: POST

**RequestBody**: `{ email: User.email, password: User.password }`

**Response**: `{ token: String, user: PublicUser }`

**Authentication**: not logged

**Authorization**: `[]`

### `api/auth/login/admin`

**Description**: Perform login as admin.

**Methods**: POST

**RequestBody**: `{ email: User.email, password: User.password }`

**Response**: `{ token: String, user: User }`

**Authentication**: not logged

**Authorization**: `[]`

### `api/auth/logout`

**Description**: Perform logout.

**Methods**: POST

**RequestBody**: `None`

**Response**: `{ status: String }`

**Authentication**: logged in

**Authorization**: `[]`

### `api/auth/register`

**Description**: Register public user account.

**Methods**: POST

**RequestBody**: `PublicUser`

**Response**: `PublicUser`

**Authentication**: not logged

**Authorization**: `[]`

### `api/bookmark/{grupo}`

**Description**: Create bookmark.

**Methods**: POST

**RequestBody**: `None`

**Response**: `UserBookmark`

**Authentication**: logged in

**Authorization**: `[]`

### `api/bookmark/{grupo}`

**Description**: Delete bookmark .

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `UserBookmark`

**Authentication**: logged in

**Authorization**: `[]`

### `api/category`

**Description**: Get categories.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Category[]`

**Authentication**: logged in

**Authorization**: `['category.viewAny']`

### `api/category`

**Description**: Create category.

**Methods**: POST

**RequestBody**: `Category`

**Response**: `Category`

**Authentication**: logged in

**Authorization**: `['category.create']`

### `api/category/{category}`

**Description**: Get category.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Category`:

**Authentication**: logged in

**Authorization**: `['category.viewAny', 'category.view']`

### `api/category/{category}`

**Description**: Update category.

**Methods**: PUT, PATCH

**RequestBody**: `Category`

**Response**: `Category`:

**Authentication**: logged in

**Authorization**: `['category.updateAny', 'category.update']`

### `api/category/{category}`

**Description**: Delete category.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Category`:

**Authentication**: logged in

**Authorization**: `['category.deleteAny', 'category.delete']`

### `api/comment`

**Description**: Create comment.

**Methods**: POST

**RequestBody**: `Comment`

**Response**: `Comment`

**Authentication**: logged in

**Authorization**: `[]`

### `api/comment/{comment}`

**Description**: Delete comment.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Comment`

**Authentication**: logged in

**Authorization**: `[]`

### `api/grupo`

**Description**: Get grupos.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Grupo[]`

**Authentication**: logged in

**Authorization**: `['grupo.viewAny']`

### `api/grupo`

**Description**: Create grupo.

**Methods**: POST

**RequestBody**: `Grupo`

**Response**: `Grupo`

**Authentication**: logged in

**Authorization**: `['grupo.create']`

### `api/grupo/{grupo}`

**Description**: Get grupo.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Grupo`

**Authentication**: logged in

**Authorization**: `['grupo.viewAny', 'grupo.view']`

### `api/grupo/{grupo}`

**Description**: Update grupo.

**Methods**: PUT, PATCH

**RequestBody**: `Grupo`

**Response**: `Grupo`

**Authentication**: logged in

**Authorization**: `['grupo.updateAny', 'grupo.update]`

### `api/grupo/{grupo}`

**Description**: Delete grupo.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Grupo`

**Authentication**: logged in

**Authorization**: `['grupo.deleteAny', 'grupo.delete]`

### `api/permission`

**Description**: Get permissions.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Permission.name[]`

**Authentication**: logged in

**Authorization**: `['permission.viewAny']`

### `api/public/categorias`

**Description**: Get public categories.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Category.name[]`

**Authentication**: not logged

**Authorization**: `[]`

### `api/public/grupos`

**Description**: Get public grupos.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicGrupo[]`

**Authentication**: not logged

**Authorization**: `[]`

### `api/public/grupos/{grupo}`

**Description**: Get public grupo.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicGrupo`

**Authentication**: not logged

**Authorization**: `[]`

### `api/public/tags`

**Description**: Get public tags.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `PublicTags`

**Authentication**: not logged

**Authorization**: `[]`

### `api/role`

**Description**: Get roles.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Role[]`

**Authentication**: logged in

**Authorization**: `['role.viewAny']`

### `api/role`

**Description**: Create role.

**Methods**: POST

**RequestBody**: `Role`

**Response**: `Role`

**Authentication**: logged in

**Authorization**: `['role.create']`

### `api/role/{role}`

**Description**: Get role.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Role`

**Authentication**: logged in

**Authorization**: `['role.viewAny', 'role.view']`

### `api/role/{role}`

**Description**: Update role.

**Methods**: PUT, PATCH

**RequestBody**: `Role`

**Response**: `Role`

**Authentication**: logged in

**Authorization**: `['role.updateAny', 'role.update']`

### `api/role/{role}`

**Description**: Delete role.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Role`

**Authentication**: logged in

**Authorization**: `['role.deleteAny', 'role.delete']`

### `api/tag`

**Description**: Get tags.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Tag[]`

**Authentication**: logged in

**Authorization**: `['tag.viewAny']`

### `api/tag`

**Description**: Create tag.

**Methods**: POST

**RequestBody**: `Tag`

**Response**: `Tag`

**Authentication**: logged in

**Authorization**: `['tag.create']`

### `api/tag/{tag}`

**Description**: Get tag.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `Tag`

**Authentication**: logged in

**Authorization**: `['tag.viewAny', 'tag.view']`

### `api/tag/{tag}`

**Description**: Update tag.

**Methods**: PUT, PATCH

**RequestBody**: `Tag`

**Response**: `Tag`

**Authentication**: logged in

**Authorization**: `['tag.updateAny', 'tag.update']`

### `api/tag/{tag}`

**Description**: Delete tag.

**Methods**: DELETE

**RequestBody**: `Tag`

**Response**: `Tag`

**Authentication**: logged in

**Authorization**: `['tag.deleteAny', 'tag.delete']`

### `api/user`

**Description**: Get users.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `User[]`

**Authentication**: logged in

**Authorization**: `['user.viewAny']`

### `api/user`

**Description**: Create user.

**Methods**: POST

**RequestBody**: `User`

**Response**: `User`

**Authentication**: logged in

**Authorization**: `['user.create']`

### `api/user/{user}`

**Description**: Get user.

**Methods**: GET, HEAD

**RequestBody**: `None`

**Response**: `User`

**Authentication**: logged in

**Authorization**: `['user.viewAny', 'user.view']`

### `api/user/{user}`

**Description**: Update user.

**Methods**: PUT, PATCH

**RequestBody**: `User`

**Response**: `User`

**Authentication**: logged in

**Authorization**: `['user.updateAny', 'user.update']`

### `api/user/{user}`

**Description**: Delete user.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `User`

**Authentication**: logged in

**Authorization**: `['user.deleteAny', 'user.delete']`

### `api/vote`

**Description**: Create vote.

**Methods**: POST

**RequestBody**: `Vote`

**Response**: `Vote`

**Authentication**: logged in

**Authorization**: `[]`

### `api/vote/{vote}`

**Description**: Update vote.

**Methods**: PUT, PATCH

**RequestBody**: `Vote`

**Response**: `Vote`

**Authentication**: logged in

**Authorization**: `[]`

### `api/vote/{vote}`

**Description**: Delete vote.

**Methods**: DELETE

**RequestBody**: `None`

**Response**: `Vote`

**Authentication**: logged in

**Authorization**: `[]`

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

**Authentication**: not logged

**Authorization**: `[]`
