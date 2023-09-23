# single-file-PHP-FFI-Raylib-wrapper
A single file [PHP8](https://github.com/php/php-src) FFI [Raylib 4.5](https://github.com/raysan5/raylib) wrapper. (Optionally, it also supports [RayGui 3.6 API](https://github.com/raysan5/raygui/) if it is compiled inside the library.)

Very W.I.P.

Meant to work out of the box with [official precompiled library releases](https://github.com/raysan5/raylib/releases) on Windows (not really tested) and on Linux, but also compatible with customized `config.h` compiled libs.

The wrapper integrates `raylib.h` + `raymath.h` + `rlgl.h` + `rlcamera.h` API. (and `raygui.h` optionaly)



Only requires `libraylib.so` or `raylib.dll` into a `.\raylib\`, or `.\lib` or `.\` sub directory.

## Why PHP ?

PHP is not just a language for under payed web developpers. 
It is also a very comfortable cross platform "batteries included" scripting language faster than the ugly spacebar addict python.
It even has a JIT.

It can be used for quick prototyping, or for reasearch purpose (as Raylib offers an interface to compute-shaders, and there is also [RubixLM](https://rubixml.com/) for machine learning ).

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
$my_vector = RL_Vector3D( 1.0 , 2.0 , 3.0 ); // init by order
// or
$my_vector = RL_Vector3D([ 'x' => 1.0 , 'z' => 3.0 , 'y' => 2.0 ]); // init by names
// or
$my_vector = FFI::new( RAYLIB_FFI_Vector3D ); // uninit
```

Arrays of Raylib's structs whose deletion is managed by PHP's garbage collector can be created this way :

```PHP

$my_palette = RL_Color_array( 256 );
$my_color_map = RL_Color_array( 320 , 240  );
$my_cube_array = RL_Vector3D_array( 3 , 5 , 8 );

// or

$my_palette = FFI::new( FFI::arrayType( RAYLIB_FFI_Color ) , [ 1 ] );
$my_color_map = FFI::new( FFI::arrayType( RAYLIB_FFI_Color ) , [ 320 , 240 ] );
$my_cube_array = FFI::new( FFI::arrayType( RAYLIB_FFI_Vector3D ) , [ 3 , 5 , 8 ] );
```

If their deletion has to be managed manually using `FFI::free()` or managed by a Raylib function, they must be created this way :

```PHP
$my_palette = RL_Color_alloc( 256 );
$my_color_map = RL_Color_alloc( 320 , 240  );
$my_cube_array = RL_Vector3D_alloc( 3 , 5 , 8 );

// or

$my_palette = FFI::new( FFI::arrayType( RAYLIB_FFI_Color ) , [ 1 ] , false , true );
$my_color_map = FFI::new( FFI::arrayType( RAYLIB_FFI_Color ) , [ 320 , 240 ] , false , true );
$my_cube_array = FFI::new( FFI::arrayType( RAYLIB_FFI_Vector3D ) , [ 3 , 5 , 8 ] , false , true );
```

## Optional RayGui 3.6 support 

If Raylib was compiled with `raygui.h`, the wrapper will try to detect it, and will set the value of `RL_SUPPORT_MODULE_RAYGUI` accordingly.

`raygui.h` functions are also prefixed with `RL_`, but consts are prefixed with `RLGUI_`.

```PHP
$W = RL_GuiGetStyle( RLGUI_SLIDER , RLGUI_BORDER_WIDTH );
```

## Customized `src/config.h` compilation

By default, the wrapper will try to detects if the library was compiled with these parameters :
- `RL_SUPPORT_MODULE_RMATH`
- `RL_SUPPORT_MODULE_RSHAPES`
- `RL_SUPPORT_MODULE_RTEXTURES`
- `RL_SUPPORT_MODULE_RTEXT`
- `RL_SUPPORT_MODULE_RMODELS`
- `RL_SUPPORT_MODULE_RAUDIO`
- `RL_SUPPORT_MODULE_RAYGUI`
- `RL_SUPPORT_CAMERA_SYSTEM`
- `RL_SUPPORT_GESTURES_SYSTEM`
- `RL_SUPPORT_SSH_KEYBOARD_RPI`
- `RL_SUPPORT_GIF_RECORDING`
- `RL_SUPPORT_FILEFORMAT_xxx` ( image, audio, models, fonts )
- `RL_SUPPORT_IMAGE_xxx` ( `EXPORT`, `GENERATION`, `MANIPULATION` )
- `RL_SUPPORT_DEFAULT_FONT`
- `RL_SUPPORT_TEXT_MANIPULATION`
- `RL_SUPPORT_MESH_GENERATION`

Other parameters will be set to default values.

So, if your Raylib was recompiled using customized `src/config.h` parameters, the wrapper has to be made aware of these new parameters before `include()`.

Look at your `src/config.h` and redefine all your customised constants in PHP using `RL_` or `RLGL_` prefixes.

For example, if you recompiled Raylib with a custom `MAX_TEXT_BUFFER_LENGTH` value, you'll have to do :

```PHP
define( 'RL_MAX_TEXT_BUFFER_LENGTH'  , 123456 /* <== your custom value*/ ); 

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

// Default near cull distance
define( 'RLGL_CULL_DISTANCE_NEAR' , 0.01 );

// Default far cull distance
define( 'RLGL_CULL_DISTANCE_FAR' , 1000.0 );
```

## Choosing the OpenGL version at runtime :

The wrapper is able to pick a different shared library (`.dll` or `.so`) according to the value of `RL_USES_OPENGL_VERSION` which can be defined in code, or passed as command line argument.

In code :
```PHP
define( 'RL_USES_OPENGL_VERSION` , 4 );
include( './raylib.ffi.php' );
```

Command line argument :
```bash
php my_raylib_app.php RL_USES_OPENGL_VERSION=4
```


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

## Passing structs by reference or by value ?

```PHP
$A = RL_Vector2( 123 , 456 ); // <= $A refers to a FFI/CData object
$B = $A ;                     // <= $A and $B refers to the same object
$A->x = 999 ;

print_r( $A );                // <= 999 , 456
print_r( $B );                // <= 999 , 456

$A = RL_Vector( 0 , 0 );      // <= $A now refers to a different object
                                 
print_r( $A );                // <= 0 , 0
print_r( $B );                // <= 999 , 456
```

```PHP
$A = RL_Vector2( 123 , 456 ); // <= $A refers to a FFI/CData object
$B = &$A ;                    // <= $B refers to $A
$A->x = 999 ;

print_r( $A );                // <= 999 , 456
print_r( $B );                // <= 999 , 456

$B = RL_Vector( 0 , 0 );      // <= $A and $B refers to this new object
                              //    the previously refered object is
                              //    sent to garbage collector.
                                 
print_r( $A );                // <= 0 , 0
print_r( $B );                // <= 0 , 0

$B = null ;                   // <= $A and $B are set to null
                              //    and the previously refered object
                              //    is sent to garbage collector
```

```PHP
$A = RL_Vector2();
$B = &$A ;

// how to set $B to Null without affecting $A ?

// $B = null ; // <= /!\ the object refered by $A
               //        would be sent to garbage collector
unset( $B );   // <= only $B is undefined, $A is left untouched

print_r( $A ); // <= 0 , 0
print_r( $B ); // Warning: Undefined

$B = null ; // <= now $B is null, and $A is untouched
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
$A = RL_Vector2(); // <= let's call this object Bob, and say $A refers to Bob
$A = clone $A ;    // <= now, $A refers to a clone of Bob, while Bob is
                   //    sent to the garbage collector because no one refers
                   //    to Bob anymore. Bye bye Bob, and welcome Bob's clone.
                   //    Same as Star Trek's transporters ?
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
$A = RL_Vector2( 123 , 456 );
$B = &$A ;
$B = RL_Vector2Add( $B , RL_Vector2( 876 , 543 ) );
print_r( $B ) ;   // <= 999 , 999
print_r( $A ) ;   // <= 999 , 999
```

```PHP
function foo( object $ARG /*objects are passed by reference*/ ) : object
{
  // $ARG refers to the object refered by the variable passed as arguement
  return $ARG ; // <= returns the reference to the object
}

$A = RL_Vector2();
$B = foo( $A ); // <= same as $B = $A ;
```

```PHP
function foo( object $ARG ) : object
{
  return clone $ARG ; // <= returns clone of refered object
}

$A = RL_Vector2();
$B = foo( $A );     // <= same as $B = clone $A ;
```

```PHP
function foo( object &$ARG /* <== reference to the variable passed as argument */) : void
{
  $ARG = null ; // <== the content of the variable passed
              // as argument is sent to garbage collector
}

$A = RL_Vector(2);
foo( $A ); // <== same as $A = null ;
```

```PHP
function foo( object &$ARG /* <== reference to the variable passed as argument */) : void
{
  $ARG = clone $ARG ; // <== the content of the variable passed
                      // as argument is replaced by a reference
                      // to a clone of the previous refered
                      // object. And the previous refered object
                      // is sent to garbage collector if no othe
                      // variable refers to it.
}

$A = RL_Vector(2);
foo( $A ); // <== same as $A = clone $A ;
```

```PHP
function foo( object $ARG ) : void
{
  $ARG->x = 789 ;
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

##  `malloc()` and `free()` ?

PHP's `FFI` can make two type of memory allocation : managed, and unmanaged.
- **managed allocations** are automatically freed by PHP's garbage collector ;
- **unmanaged allocations** must be set free manually using `FFI::free()` or by a C function that internally uses `free()`.

Example of **managed** allocation :
```PHP
$ICON = RL_Color_array( 32 , 32 ); // <= create a managed CData 2D array
                                   //    of type `struct Color`

$ICON = null ; // <= the array is sent to PHP's garbage collector.
```

Example of **unmanaged** allocation :
```PHP
$ICON = RL_Color_alloc( 32 , 32 ); // <== create an unmanaged CData 2D array
                                   //     of type `struct Color`

// $ICON = null ; // <== WARNING ! DONT ! or else, you'll lose the reference
                  //     and it would create a memory leak !

FFI::free( $ICON ); // <== unmanaged allocation must be set free manually,
                    //     or else it would create a memory leak !
```

Other example of **unmanaged** allocation (see [examples/40_raw_data.php](https://github.com/SuperUserNameMan/single-file-PHP-FFI-Raylib-wrapper/blob/main/examples/40_raw_data.php) ) :
```PHP
// we use `RL_Color_alloc()` instead of `RL_Color_array()` because
// the `$PIXELS` array will be deleted through `RL_UnloadImage()`
$PIXELS = RL_Color_alloc( $WIDTH * $HEIGHT ); // <== we create an unmanaged allocation
                                              // that will be set free by RL_UnloadImage()
...

$IMAGE = RL_Image(); // <== this Image struct is managed
                     //     by PHP's garbage collector,

$IMAGE->data = $PIXELS ; // <== but we bind to it the unmanaged
                         //     array created above
...

$TEXTURE = RL_LoadTextureFromImage( $IMAGE ); // <== make use of the Image

RL_UnloadImage( $IMAGE ); // <== and this is where the unmanaged $PIXELS
                          //     allocation is set free by Raylib
...

$IMAGE = null ; // <== now the emptied Image struct
                //     is sent to PHP's garbage collector
```

