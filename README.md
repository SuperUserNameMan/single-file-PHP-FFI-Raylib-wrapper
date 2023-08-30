# single-file-PHP-FFI-Raylib-wrapper
A single file [PHP8](https://github.com/php/php-src) FFI [Raylib 4.5](https://github.com/raysan5/raylib) wrapper.

Very W.I.P.

Meant to work out of the box with official precompiled library releases.

The wrapper integrates RLAPI + RMAPI + RLGL API.

Only need `libraylib.so` or `raylib.dll` into a `.\raylib\`, or `.\lib` or `.\` sub directory.

## Notes :

All RLAPI and RMAPI functions, enums, consts and typedefs are prefixed with `RL_`.

```PHP
RL_ClearBackground( RL_WHITE );
``

RLGL functions are also prefixed with `RL_`, but RLGL consts are prefixed with `RLGL_`.

```PHP
RL_rlMatrixMode( RLGL_PROJECTION );
```

Raylib's structs can be created this way :

```PHP

$my_vector = RL_Vector3D(); // uninit
//or
$my_vector = RL_Vector3D( 1.0 , 2.0 , 3.0 ); // init
// or
$my_vector = FFI::new( RAYLIB_FFI_Vector3D ); // uninit
```

Arrays of Raylib's structs can be created this way :

```PHP

$my_palette = RL_Color_array( 256 );
$my_color_map = RL_Color_array( 320 , 240  );
$my_cube_array = RL_Vector3D_array( 3 , 5 , 8 );

// or

$my_palette = FFI::new( FFI::arrayType( RAYLIB_FFI_Color ) , [ 1 ] );
$my_color_map = FFI::new( FFI::arrayType( RAYLIB_FFI_Color ) , [ 320 , 240 ] );
$my_cube_array = FFI::new( FFI::arrayType( RAYLIB_FFI_Vector3D ) , [ 3 , 5 , 8 ] );
```
