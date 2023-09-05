# single-file-PHP-FFI-Raylib-wrapper
A single file [PHP8](https://github.com/php/php-src) FFI [Raylib 4.5](https://github.com/raysan5/raylib) wrapper. (Optionally, it also supports [RayGui 3.6 API](https://github.com/raysan5/raygui/) if it is compiled inside the library.)

Very W.I.P.

Meant to work out of the box with [official precompiled library releases](https://github.com/raysan5/raylib/releases) on Windows (not really tested) and on Linux.

The wrapper integrates `raylib.h` + `raymath.h` + `rlgl.h` + `rlcamera.h` API.



Only requires `libraylib.so` or `raylib.dll` into a `.\raylib\`, or `.\lib` or `.\` sub directory.

## Notes :

All `raylib.h`, `raymath.h` and `rcamera.h` functions, enums, consts and typedefs are prefixed with `RL_`.

```PHP
RL_ClearBackground( RL_WHITE );
```

`rlgl.h` functions are also prefixed with `RL_`, but consts are prefixed with `RLGL_`.

```PHP
RL_rlMatrixMode( RLGL_PROJECTION );
```
( Note : adding prefixes was required because some Raylib names were conflicting with PHP, and `RLGL_` was also required to be different than `RL_` because `rlgl.h` contains some duplicates names with different values. )

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

## Optional RayGui 3.6 support 

If RayGui was compiled inside your library, you can tell it to the wrapper before include :

```PHP
define( 'RL_SUPPORT_MODULE_RAYGUI' , true );

include('./path/to/raylib.ffi.php');
```

`raygui.h` functions are also prefixed with `RL_`, but consts are prefixed with `RLGUI_`.

```PHP
$W = RL_GuiGetStyle( RLGUI_SLIDER , RLGUI_BORDER_WIDTH );
```

## Customized `src/config.h` compilation

If Raylib is recompiled using customized `src/config.h` parameters, the wrapper has to be made aware of these new parameters before `include()`.

Look at your `src/config.h` and redefine all your customised constants in PHP using `RL_` or `RLGL_` prefixes.

For example, if you recompiled Raylib with `.tga` image support, you'll have to do :

```PHP
define( 'RL_SUPPORT_FILEFORMAT_TGA'  , true );

include('./your/path/to/raylib.ffi.php');
```

Regarding custom OpenGL version, the wrapper makes use of a special `RL_USES_OPENGL_VERSION` definition :

```PHP
// 1 => OpenGL 1.1
// 2 => OpenGL 2.1
// 3 => OpenGL 3.3
// 4 => OpenGL 4.3
// 0xE2 => OpenGLES2

// Tells the wrapper Raylib was compiled for OpenGL 4.3
define( 'RL_USES_OPENGL_VERSION' , 4 ); 
```
Other OpenGL customized definitions must use the `RLGL_` prefix :

```PHP
// Default internal render batch elements limits
define( 'RLGL_DEFAULT_BATCH_BUFFER_ELEMENTS' , 8192 );

// Default number of batch buffers (multi-buffering)
define( 'RLGL_DEFAULT_BATCH_BUFFERS' , 1 );

// Default number of batch draw calls (by state changes: mode, texture)
define( 'RLGL_DEFAULT_BATCH_DRAWCALLS' , 256 );

// Maximum number of textures units that can be activated
// on batch drawing (SetShaderValueTexture())
define( 'RLGL_DEFAULT_BATCH_MAX_TEXTURE_UNITS' , 4 );

// Maximum size of Matrix stack
define( 'RLGL_MAX_MATRIX_STACK_SIZE' , 32 );

// Maximum number of shader locations supported
define( 'RLGL_MAX_SHADER_LOCATIONS' , 32 );

// Default near cull distance
define( 'RLGL_CULL_DISTANCE_NEAR' , 0.01 );

// Default far cull distance
define( 'RLGL_CULL_DISTANCE_FAR' , 1000.0 );
```

## Choosing the OpenGL version at runtime :

The wrapper is able to pick a different shared library (`.dll` or `.so`) according to the value of `RL_USES_OPENGL_VERSION`.

| RL_USES_OPENGL_VERSION | OpenGL version | Lib name Linux | Lib name Windows |
|-----|---|---|---|
| 1 | OpenGL 1.1 | `libraylib_opengl1.so` | `raylib_opengl1.dll` |
| 2 | OpenGL 2.1 | `libraylib_opengl2.so` | `raylib_opengl2.dll` |
| 3 | OpenGL 3.3 (default) | `libraylib_opengl3.so` | `raylib_opengl3.dll` |
| 4 | OpenGL 4.3 | `libraylib_opengl4.so` | `raylib_opengl4.dll` |
| 0xE2 (or 226 in decimal) | OpenGLES2 | `libraylib_opengl226.so` | `raylib_opengl226.dll` |

The wrapper will scan each one of these subdirectories in this order using the name that matches `RL_USES_OPENGL_VERSION` :
- `./raylib/`
- `./libs/`
- `./lib/`
- `./` (project root)

If it fails, it tries again using `libraylib.so` or `raylib.dll`.

## Passing structs by reference or by value ? `malloc()` and `free()` ?

```PHP
$A = RL_Vector2(); // <= $A refers to a FFI/CData object
$B = $A ;          // <= $A and $B refers to the same object
```

```PHP
$A = RL_Vector2();
$B = RL_Vector2();
$B = $A ;          // <= $A and $B refers to the same object
                   //    and the object previously refered
                   //    by $B is sent to garbage collector
                   //    because no one refers to it anymore.
```

```PHP
$A = RL_Vector2();
$B = clone $A ;    // <= $B refers to a clone of $A's object
```

```PHP
$A = RL_Vector2();
$B = RL_Vector2();
$B = clone $A ;    // <= $B refers to a clone of $A's object
                   //    and the object previously refered
                   //    by $B is sent to garbage collector
                   //    because no one refers to it anymore.
```


```PHP
$A = RL_Vector2();
$B = RL_Vector2();
$C = $B ;
$B = clone $A ;    // <= $B refers to a clone of $A's object
                   //    and the object previously refered
                   //    by $B is still refered by $C.
```

```PHP
$A = RL_Vector2() ;
$B = $A ;
$A = null ;        // <= $A abandonned the reference to the object
print_r( $B );     // <= $B still refers to the object
$B = null ;        // <= $B abandonned the last reference to the object
                   //       and the object is sent to garbage colllector.
```

```PHP
function foo( object $A /*objects are passed by reference*/ ) : object
{
  return $A ; // <= returns the reference 
}

$A = RL_Vector2();
$B = foo( $A ); // <= same as $B = $A ;
```

```PHP
function foo( object $A ) : object
{
  return clone $A ; // <= returns clone of refered object
}

$A = RL_Vector2();
$B = foo( $A );     // <= same as $B = clone $A ;
```


```PHP
function foo( object $A ) : void
{
  $A->x = 789 ;
}

$A = RL_Vector2( 123 , 456 );
foo( $A );
print_r( $A );    // <= content of $A's object altered inside foo()
```

```PHP
class Player
{
  public object $POS ;
}

$PLAYER = new Player();
$PLAYER->POS = RL_Vector2();

$CAMERA = RL_Camera2D();
$CAMERA->target = $PLAYER->POS ; // <= copy of content
                                 //    because $CAMERA->target
                                 //    is property of a FFI/CData object

$PLAYER->POS = $CAMERA->target ; // <= $PLAYER->POS refers to $CAMERA->target

$PLAYER->POS = clone $CAMERA->target ; // <= $PLAYER->POS refers to a clone of $CAMERA->target
```

Regarding the Raylib's C API, some function requires a pointer to an object :
```C
void UpdateCamera( Camera* camera , int mode );
```

In PHP, you call it this way :
```PHP
$CAMERA = RL_Camera2D();

// Using the wrapper :

RL_UpdateCamera( $CAMERA , RL_CAMERA_FREE );

// or using FFI :

$RAYLIB_FFI->UpdateCamera( FFI::addr( $CAMERA ) , RL_CAMERA_FREE );
```

Same thing with predefined Raylib's colors :
```PHP
$COLOR = RL_WHITE ; // <= $COLOR refers to RL_WHITE which is FFI/CData object
$COLOR->r = 0 ;     // <= RL_WHITE is also affected by this change

$COLOR = clone RL_WHITE ; // <= $COLOR refers to a clone of RL_WHITE
$COLOR->r = 0 :           // <= RL_WHITE remains untouched by this change
```
