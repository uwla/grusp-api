# GRUSP API

Backend for GRUSP.

Built with [Laravel 10](https://laravel.com/docs/10.x/).

## Routes

The following routes are defined

| Method     | URL                            | Name                | Action                                  |
| ---------  | ------------------------------ | ------------------- | --------------------------------------- |
| GET, HEAD  | api/account/bookmarks          | -                   | AccountController@bookmarks             |
| GET, HEAD  | api/account/comments           | -                   | AccountController@comments              |
| GET, HEAD  | api/account/grupos             | -                   | AccountController@grupos                |
| POST       | api/account/password/link      | -                   | AccountController@sendResetLinkEmail    |
| POST       | api/account/password/reset     | password.reset      | AccountController@resetPassword         |
| GET, HEAD  | api/account/profile            |                     | AccountController@getProfile            |
| POST       | api/account/profile            |                     | AccountController@updateProfile         |
| GET, HEAD  | api/account/verify/{id}/{hash} | verification.verify | AccountController@verifyEmail           |
| POST       | api/account/verify_link        | -                   | AccountController@sendVerificationEmail |
| GET, HEAD  | api/account/votes              | -                   | AccountController@votes                 |
| POST       | api/auth/login                 | login               | AuthController@login                    |
| POST       | api/auth/login/admin           | -                   | AuthController@loginAdmin               |
| POST       | api/auth/logout                | -                   | AuthController@logout                   |
| POST       | api/auth/register              | register            | AuthController@register                 |
| POST       | api/bookmark/{grupo}           | -                   | BookmarkController@store                |
| DELETE     | api/bookmark/{grupo}           | -                   | BookmarkController@destroy              |
| GET, HEAD  | api/category                   | category.index      | CategoryController@index                |
| POST       | api/category                   | category.store      | CategoryController@store                |
| GET, HEAD  | api/category/{category}        | category.show       | CategoryController@show                 |
| PUT, PATCH | api/category/{category}        | category.update     | CategoryController@update               |
| DELETE     | api/category/{category}        | category.destroy    | CategoryController@destroy              |
| POST       | api/comment                    | comment.store       | CommentController@store                 |
| PUT, PATCH | api/comment/{comment}          | comment.update      | CommentController@update                |
| DELETE     | api/comment/{comment}          | comment.destroy     | CommentController@destroy               |
| GET, HEAD  | api/grupo                      | grupo.index         | GrupoController@index                   |
| POST       | api/grupo                      | grupo.store         | GrupoController@store                   |
| GET, HEAD  | api/grupo/{grupo}              | grupo.show          | GrupoController@show                    |
| PUT, PATCH | api/grupo/{grupo}              | grupo.update        | GrupoController@update                  |
| DELETE     | api/grupo/{grupo}              | grupo.destroy       | GrupoController@destroy                 |
| GET, HEAD  | api/permission                 | -                   | PermissionController@index              |
| GET, HEAD  | api/public/categorias          | -                   | PublicController@categories             |
| GET, HEAD  | api/public/grupos              | -                   | PublicController@grupos                 |
| GET, HEAD  | api/public/grupos/{grupo}      | -                   | PublicController@grupo                  |
| GET, HEAD  | api/public/tags                | -                   | PublicController@tags                   |
| GET, HEAD  | api/role                       | role.index          | RoleController@index                    |
| POST       | api/role                       | role.store          | RoleController@store                    |
| GET, HEAD  | api/role/{role}                | role.show           | RoleController@show                     |
| PUT, PATCH | api/role/{role}                | role.update         | RoleController@update                   |
| DELETE     | api/role/{role}                | role.destroy        | RoleController@destroy                  |
| GET, HEAD  | api/tag                        | tag.index           | TagController@index                     |
| POST       | api/tag                        | tag.store           | TagController@store                     |
| GET, HEAD  | api/tag/{tag}                  | tag.show            | TagController@show                      |
| PUT, PATCH | api/tag/{tag}                  | tag.update          | TagController@update                    |
| DELETE     | api/tag/{tag}                  | tag.destroy         | TagController@destroy                   |
| GET, HEAD  | api/user                       | user.index          | UserController@index                    |
| POST       | api/user                       | user.store          | UserController@store                    |
| GET, HEAD  | api/user/{user}                | user.show           | UserController@show                     |
| PUT, PATCH | api/user/{user}                | user.update         | UserController@update                   |
| DELETE     | api/user/{user}                | user.destroy        | UserController@destroy                  |
| POST       | api/vote                       | vote.store          | VoteController@store                    |
| PUT, PATCH | api/vote/{vote}                | vote.update         | VoteController@update                   |
| DELETE     | api/vote/{vote}                | vote.destroy        | VoteController@destroy                  |
| GET, HEAD  | sanctum/csrf-cookie            | sanctum.csrf-cookie | CsrfCookieController@show               |