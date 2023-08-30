# single-file-PHP-FFI-Raylib-wrapper
A single file [PHP8](https://github.com/php/php-src) FFI [Raylib 4.5](https://github.com/raysan5/raylib) wrapper.

Very W.I.P.

Only need `libraylib.so` or `raylib.dll` into a `.\raylib\`, or `.\lib` or `.\` sub directory.

## Notes :

All RLAPI function, enums, consts and typedefs are prefixed with `RL_`.

```PHP
RL_ClearBackground( RL_WHITE );
```

Raylib's structs can be created this way :

```PHP

$my_vector = RL_Vector3D( 1.0 , 2.0, 3.0 );

// or

$my_vector = FFI::new( RAYLIB_FFI_Vector3D );

```
