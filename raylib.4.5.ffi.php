<?php
//TAB=4
//---------------------------------------------------------------------------------------------
//XXX This Raylib 4.5 PHP8 FFI single file wrapper is composed by Terminajones.com
//XXX
//XXX This PHP FFI wrapper is based uppon the official Raylib's 4.5 headers files which are
//XXX available here https://github.com/raysan5/raylib
//XXX and which were distributed under the following license :
//--------------------------------------------------------------------------------------------
/**********************************************************************************************
*
*   raylib v4.5 - A simple and easy-to-use library to enjoy videogames programming (www.raylib.com)
*
*   FEATURES:
*       - NO external dependencies, all required libraries included with raylib
*       - Multiplatform: Windows, Linux, FreeBSD, OpenBSD, NetBSD, DragonFly,
*                        MacOS, Haiku, Android, Raspberry Pi, DRM native, HTML5.
*       - Written in plain C code (C99) in PascalCase/camelCase notation
*       - Hardware accelerated with OpenGL (1.1, 2.1, 3.3, 4.3 or ES2 - choose at compile)
*       - Unique OpenGL abstraction layer (usable as standalone module): [rlgl]
*       - Multiple Fonts formats supported (TTF, XNA fonts, AngelCode fonts)
*       - Outstanding texture formats support, including compressed formats (DXT, ETC, ASTC)
*       - Full 3d support for 3d Shapes, Models, Billboards, Heightmaps and more!
*       - Flexible Materials system, supporting classic maps and PBR maps
*       - Animated 3D models supported (skeletal bones animation) (IQM)
*       - Shaders support, including Model shaders and Postprocessing shaders
*       - Powerful math module for Vector, Matrix and Quaternion operations: [raymath]
*       - Audio loading and playing with streaming support (WAV, OGG, MP3, FLAC, XM, MOD)
*       - VR stereo rendering with configurable HMD device parameters
*       - Bindings to multiple programming languages available!
*
*   NOTES:
*       - One default Font is loaded on InitWindow()->LoadFontDefault() [core, text]
*       - One default Texture2D is loaded on rlglInit(), 1x1 white pixel R8G8B8A8 [rlgl] (OpenGL 3.3 or ES2)
*       - One default Shader is loaded on rlglInit()->rlLoadShaderDefault() [rlgl] (OpenGL 3.3 or ES2)
*       - One default RenderBatch is loaded on rlglInit()->rlLoadRenderBatch() [rlgl] (OpenGL 3.3 or ES2)
*
*   DEPENDENCIES (included):
*       [rcore] rglfw (Camilla Löwy - github.com/glfw/glfw) for window/context management and input (PLATFORM_DESKTOP)
*       [rlgl] glad (David Herberth - github.com/Dav1dde/glad) for OpenGL 3.3 extensions loading (PLATFORM_DESKTOP)
*       [raudio] miniaudio (David Reid - github.com/mackron/miniaudio) for audio device/context management
*
*   OPTIONAL DEPENDENCIES (included):
*       [rcore] msf_gif (Miles Fogle) for GIF recording
*       [rcore] sinfl (Micha Mettke) for DEFLATE decompression algorithm
*       [rcore] sdefl (Micha Mettke) for DEFLATE compression algorithm
*       [rtextures] stb_image (Sean Barret) for images loading (BMP, TGA, PNG, JPEG, HDR...)
*       [rtextures] stb_image_write (Sean Barret) for image writing (BMP, TGA, PNG, JPG)
*       [rtextures] stb_image_resize (Sean Barret) for image resizing algorithms
*       [rtext] stb_truetype (Sean Barret) for ttf fonts loading
*       [rtext] stb_rect_pack (Sean Barret) for rectangles packing
*       [rmodels] par_shapes (Philip Rideout) for parametric 3d shapes generation
*       [rmodels] tinyobj_loader_c (Syoyo Fujita) for models loading (OBJ, MTL)
*       [rmodels] cgltf (Johannes Kuhlmann) for models loading (glTF)
*       [rmodels] Model3D (bzt) for models loading (M3D, https://bztsrc.gitlab.io/model3d)
*       [raudio] dr_wav (David Reid) for WAV audio file loading
*       [raudio] dr_flac (David Reid) for FLAC audio file loading
*       [raudio] dr_mp3 (David Reid) for MP3 audio file loading
*       [raudio] stb_vorbis (Sean Barret) for OGG audio loading
*       [raudio] jar_xm (Joshua Reisenauer) for XM audio module loading
*       [raudio] jar_mod (Joshua Reisenauer) for MOD audio module loading
*
*
*   LICENSE: zlib/libpng
*
*   raylib is licensed under an unmodified zlib/libpng license, which is an OSI-certified,
*   BSD-like license that allows static linking with closed source software:
*
*   Copyright (c) 2013-2023 Ramon Santamaria (@raysan5)
*
*   This software is provided "as-is", without any express or implied warranty. In no event
*   will the authors be held liable for any damages arising from the use of this software.
*
*   Permission is granted to anyone to use this software for any purpose, including commercial
*   applications, and to alter it and redistribute it freely, subject to the following restrictions:
*
*     1. The origin of this software must not be misrepresented; you must not claim that you
*     wrote the original software. If you use this software in a product, an acknowledgment
*     in the product documentation would be appreciated but is not required.
*
*     2. Altered source versions must be plainly marked as such, and must not be misrepresented
*     as being the original software.
*
*     3. This notice may not be removed or altered from any source distribution.
*
**********************************************************************************************/

$_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 = basename( $_SERVER['PHP_SELF'] ) == basename( __FILE__ ) ;

if ( !isset( $RAYLIB_H ) ){
$RAYLIB_H = '' ;
$RAYGUI_H = '' ;

define( 'RAYLIB_VERSION_MAJOR' , 4 );
define( 'RAYLIB_VERSION_MINOR' , 5 );
define( 'RAYLIB_VERSION_PATCH' , 0 );
define( 'RAYLIB_VERSION' , "4.5" );

function define_default( string $DEFNAME , $DEFVAL ) { defined( $DEFNAME ) || define( $DEFNAME , $DEFVAL ); }

for( $i = 1 ; $i <= 4 ; $i++ ) if ( in_array( "RL_USES_OPENGL_VERSION=$i" , $argv ) ) define_default( 'RL_USES_OPENGL_VERSION' , $i ) ;
if ( in_array( 'RL_USES_OPENGL_VERSION=0xE2' , $argv ) || in_array( 'RL_USES_OPENGL_VERSION=226' , $argv ) ) define_default( 'RL_USES_OPENGL_VERSION' , 0xE2 );

for( $i = 1 ; $i <= 4 ; $i++ ) if ( in_array( "OPENGL=$i" , $argv ) ) define_default( 'RL_USES_OPENGL_VERSION' , $i ) ;
if ( in_array( 'OPENGL=0xE2' , $argv ) || in_array( 'OPENGL=226' , $argv ) ) define_default( 'RL_USES_OPENGL_VERSION' , 0xE2 );

define_default( 'RL_USES_OPENGL_VERSION'       ,   3 );

$_RAYLIB_TEST_PATHES ??= [
	'./raylib/',
	'./libs/',
	'./lib/',
	'./',
	'',
];

$_RAYLIB_SHARED_LIBRARY_NAMES ??= match( PHP_OS_FAMILY )
{
	'Linux'   => [
		'libraylib_opengl'.RL_USES_OPENGL_VERSION.'.so' ,
		'libraylib.so' ,
	],
	'Windows' => [
		'raylib_opengl'.RL_USES_OPENGL_VERSION.'.dll' ,
		'raylib.dll' ,
	],
};

foreach( $_RAYLIB_SHARED_LIBRARY_NAMES as $_RAYLIB_SHARED_LIBRARY )
{
	foreach( $_RAYLIB_TEST_PATHES as $_RAYLIB_TEST_PATH )
	{
		$_RAYLIB_PATH = $_RAYLIB_TEST_PATH.$_RAYLIB_SHARED_LIBRARY ;
		if ( file_exists( $_RAYLIB_PATH ) )
		{
			echo "Found $_RAYLIB_PATH".PHP_EOL;
			break 2;
		}
	}
}


//----------------------------------------------------------------------------------
// RL_PLATFORM_xxx definitions
//----------------------------------------------------------------------------------

define_default( 'RL_PLATFORM_DESKTOP' ,  true );
define_default( 'RL_PLATFORM_ANDROID' , FALSE );
define_default( 'RL_PLATFORM_RPI'     , FALSE );

//----------------------------------------------------------------------------------
// Other compile-time default definitions :
//----------------------------------------------------------------------------------

// try to automatically detects if the library was compiled with each module
$_RAYLIB_CONTENT = file_get_contents( $_RAYLIB_PATH );

define( 'RAYGUI_VERSION_3_5_DETECTED' , str_contains( $_RAYLIB_CONTENT , 'GuiTabBar'       ) ); // since 3.5
define( 'RAYGUI_VERSION_4_DETECTED'   , str_contains( $_RAYLIB_CONTENT , 'GuiToggleSlider' ) ); // since 4.0

define_default( 'RL_SUPPORT_MODULE_RAYGUI' , RAYGUI_VERSION_3_5_DETECTED && ! RAYGUI_VERSION_4_DETECTED );

define_default( 'RL_SUPPORT_MODULE_RAUDIO'         , str_contains( $_RAYLIB_CONTENT , 'LoadAudioStream'     ) );
define_default( 'RL_SUPPORT_MODULE_RLGL'           , str_contains( $_RAYLIB_CONTENT , 'MatrixPerspective'   ) );
define_default( 'RL_SUPPORT_MODULE_RMATH'          , str_contains( $_RAYLIB_CONTENT , 'Normalize'           ) );
define_default( 'RL_SUPPORT_MODULE_RMODELS'        , str_contains( $_RAYLIB_CONTENT , 'LoadModel'           ) );
define_default( 'RL_SUPPORT_MODULE_RSHAPES'        , str_contains( $_RAYLIB_CONTENT , 'DrawPixel'           ) );
define_default( 'RL_SUPPORT_MODULE_RTEXT'          , str_contains( $_RAYLIB_CONTENT , 'LoadFont'            ) );
define_default( 'RL_SUPPORT_MODULE_RTEXTURES'      , str_contains( $_RAYLIB_CONTENT , 'LoadImage'           ) );

define_default( 'RL_SUPPORT_CAMERA_SYSTEM'         , str_contains( $_RAYLIB_CONTENT , 'GetCameraForward'    ) );

define_default( 'RL_SUPPORT_GESTURES_SYSTEM'       , str_contains( $_RAYLIB_CONTENT , 'ProcessGestureEvent' ) );
define_default( 'RL_SUPPORT_MOUSE_GESTURES'        , FALSE );

define_default( 'RL_SUPPORT_SSH_KEYBOARD_RPI'      , str_contains( $_RAYLIB_CONTENT , 'ProcessKeyboard'     ) );
define_default( 'RL_SUPPORT_WINMM_HIGHRES_TIMER'   , true );
define_default( 'RL_SUPPORT_PARTIALBUSY_WAIT_LOOP' , true );

define_default( 'RL_SUPPORT_SCREEN_CAPTURE'        , true );
define_default( 'RL_SUPPORT_GIF_RECORDING'         , str_contains( $_RAYLIB_CONTENT , '/screenrec%03i.gif'  ) );

define_default( 'RL_SUPPORT_COMPRESSION_API'       , true );
define_default( 'RL_SUPPORT_CUSTOM_FRAME_CONTROL'  , FALSE );


define_default( 'RL_MAX_FILEPATH_CAPACITY' , 8192 );
define_default( 'RL_MAX_FILEPATH_LENGTH'   , 4096 );

define_default( 'RL_MAX_KEYBOARD_KEYS'     , 512 );
define_default( 'RL_MAX_MOUSE_BUTTONS'     ,   8 );
define_default( 'RL_MAX_GAMEPADS'          ,   4 );
define_default( 'RL_MAX_GAMEPAD_AXIS'      ,   8 );
define_default( 'RL_MAX_GAMEPAD_BUTTONS'   ,  32 );
define_default( 'RL_MAX_TOUCH_POINTS'      ,   8 );
define_default( 'RL_MAX_KEY_PRESSED_QUEUE' ,  16 );
define_default( 'RL_MAX_CHAR_PRESSED_QUEUE',  16 );

define_default( 'RL_MAX_DECOMPRESSION_SIZE',  64 );


//------------------------------------------------------------------------------------
// Module: rlgl - Configuration values
//------------------------------------------------------------------------------------

define_default( 'RLGL_DEFAULT_BATCH_BUFFERS'           ,   1 );
define_default( 'RLGL_DEFAULT_BATCH_DRAWCALLS'         , 256 );
define_default( 'RLGL_DEFAULT_BATCH_MAX_TEXTURE_UNITS' ,   4 );

define_default( 'RLGL_MAX_MATRIX_STACK_SIZE'           ,  32 );

define_default( 'RLGL_MAX_SHADER_LOCATIONS'            ,  32 );

define_default( 'RLGL_CULL_DISTANCE_NEAR'          ,    0.01 );
define_default( 'RLGL_CULL_DISTANCE_FAR'           , 1000.0  );


define_default( 'RLGL_DEFAULT_SHADER_ATTRIB_NAME_POSITION'    , "vertexPosition"  );  // Bound by default to shader location: 0
define_default( 'RLGL_DEFAULT_SHADER_ATTRIB_NAME_TEXCOORD'    , "vertexTexCoord"  );  // Bound by default to shader location: 1

define_default( 'RLGL_DEFAULT_SHADER_ATTRIB_NAME_NORMAL'      , "vertexNormal"    );  // Bound by default to shader location: 2
define_default( 'RLGL_DEFAULT_SHADER_ATTRIB_NAME_COLOR'       , "vertexColor"     );  // Bound by default to shader location: 3
define_default( 'RLGL_DEFAULT_SHADER_ATTRIB_NAME_TANGENT'     , "vertexTangent"   );  // Bound by default to shader location: 4
define_default( 'RLGL_DEFAULT_SHADER_ATTRIB_NAME_TEXCOORD2'   , "vertexTexCoord2" );  // Bound by default to shader location: 5

define_default( 'RLGL_DEFAULT_SHADER_UNIFORM_NAME_MVP'        , "mvp"             );  // model-view-projection matrix
define_default( 'RLGL_DEFAULT_SHADER_UNIFORM_NAME_VIEW'       , "matView"         );  // view matrix
define_default( 'RLGL_DEFAULT_SHADER_UNIFORM_NAME_PROJECTION' , "matProjection"   );  // projection matrix
define_default( 'RLGL_DEFAULT_SHADER_UNIFORM_NAME_MODEL'      , "matModel"        );  // model matrix
define_default( 'RLGL_DEFAULT_SHADER_UNIFORM_NAME_NORMAL'     , "matNormal"       );  // normal matrix (transpose(inverse(matModelView))
define_default( 'RLGL_DEFAULT_SHADER_UNIFORM_NAME_COLOR'      , "colDiffuse"      );  // color diffuse (base tint color, multiplied by texture color)
define_default( 'RLGL_DEFAULT_SHADER_SAMPLER2D_NAME_TEXTURE0' , "texture0"        );  // texture0 (texture slot active 0)
define_default( 'RLGL_DEFAULT_SHADER_SAMPLER2D_NAME_TEXTURE1' , "texture1"        );  // texture1 (texture slot active 1)
define_default( 'RLGL_DEFAULT_SHADER_SAMPLER2D_NAME_TEXTURE2' , "texture2"        );  // texture2 (texture slot active 2)


//------------------------------------------------------------------------------------
// Module: rshapes - Configuration Flags
//------------------------------------------------------------------------------------
// Use QUADS instead of TRIANGLES for drawing when possible
// Some lines-based shapes could still use lines
define_default( 'RL_SUPPORT_QUADS_DRAW_MODE'       ,  true );

//------------------------------------------------------------------------------------
// Module: rtextures - Configuration Flags
//------------------------------------------------------------------------------------
// Select the desired fileformats to be supported for image data loading
define_default( 'RL_SUPPORT_FILEFORMAT_PNG'  , str_contains( $_RAYLIB_CONTENT , "\0bad png sig\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_BMP'  , str_contains( $_RAYLIB_CONTENT , "\0.bmp\0"     ) );
define_default( 'RL_SUPPORT_FILEFORMAT_TGA'  , str_contains( $_RAYLIB_CONTENT , "\0.tga\0"     ) );
define_default( 'RL_SUPPORT_FILEFORMAT_JPG'  , str_contains( $_RAYLIB_CONTENT , "\0.jpg\0"     ) );
define_default( 'RL_SUPPORT_FILEFORMAT_GIF'  , str_contains( $_RAYLIB_CONTENT , "\0not GIF\0"  ) ); // XXX
define_default( 'RL_SUPPORT_FILEFORMAT_QOI'  , str_contains( $_RAYLIB_CONTENT , "\0.qoi\0"     ) );
define_default( 'RL_SUPPORT_FILEFORMAT_PSD'  , str_contains( $_RAYLIB_CONTENT , "\0.bmp\0"     ) );
define_default( 'RL_SUPPORT_FILEFORMAT_DDS'  , str_contains( $_RAYLIB_CONTENT , "\0.dds\0"     ) );
define_default( 'RL_SUPPORT_FILEFORMAT_HDR'  , str_contains( $_RAYLIB_CONTENT , "\0.hdr\0"     ) );
define_default( 'RL_SUPPORT_FILEFORMAT_PIC'  , str_contains( $_RAYLIB_CONTENT , "\0.pic\0"     ) );
define_default( 'RL_SUPPORT_FILEFORMAT_PNM'  , str_contains( $_RAYLIB_CONTENT , "\0.ppm\0"     ) ); // XXX .ppm or pgm
define_default( 'RL_SUPPORT_FILEFORMAT_KTX'  , str_contains( $_RAYLIB_CONTENT , "\0.ktx\0"     ) );
define_default( 'RL_SUPPORT_FILEFORMAT_ASTC' , str_contains( $_RAYLIB_CONTENT , "\0.astc\0"    ) );
define_default( 'RL_SUPPORT_FILEFORMAT_PKM'  , str_contains( $_RAYLIB_CONTENT , "\0.pkm\0"     ) );
define_default( 'RL_SUPPORT_FILEFORMAT_PVR'  , str_contains( $_RAYLIB_CONTENT , "\0.pvr\0"     ) );

// rtextures: Configuration values
//------------------------------------------------------------------------------------

// Support image export functionality (.png, .bmp, .tga, .jpg, .qoi)
define_default( 'RL_SUPPORT_IMAGE_EXPORT'       , str_contains( $_RAYLIB_CONTENT , '%s_FORMAT' ) );

// Support procedural image generation functionality (gradient, spot, perlin-noise, cellular)
define_default( 'RL_SUPPORT_IMAGE_GENERATION'   , str_contains( $_RAYLIB_CONTENT , 'GenImageCellular' ) );

// Support multiple image editing functions to scale, adjust colors, flip, draw on images, crop...
// If not defined, still some functions are supported: ImageFormat(), ImageCrop(), ImageToPOT()
define_default( 'RL_SUPPORT_IMAGE_MANIPULATION' , str_contains( $_RAYLIB_CONTENT , 'ImageToPOT' ) );

//------------------------------------------------------------------------------------
// Module: rtext - Configuration Flags
//------------------------------------------------------------------------------------
// Default font is loaded on window initialization to be available for the user to render simple text
// NOTE: If enabled, uses external module functions to load default raylib font
define_default( 'RL_SUPPORT_DEFAULT_FONT'        , str_contains( $_RAYLIB_CONTENT , 'LoadFontDefault' ) );
// Selected desired font fileformats to be supported for loading
define_default( 'RL_SUPPORT_FILEFORMAT_FNT'      , str_contains( $_RAYLIB_CONTENT , "\0.fnt\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_TTF'      , str_contains( $_RAYLIB_CONTENT , "\0.ttf\0" ) );

// Support text management functions
// If not defined, still some functions are supported: TextLength(), TextFormat()
define_default( 'RL_SUPPORT_TEXT_MANIPULATION'   , str_contains( $_RAYLIB_CONTENT , 'TextCopy' ) );

// rtext: Configuration values
//------------------------------------------------------------------------------------
define_default( 'RL_MAX_TEXT_BUFFER_LENGTH'      , 1024 ); // Size of internal static buffers used on some functions:
                                                           // TextFormat(), TextSubtext(), TextToUpper(), TextToLower(), TextToPascal(), TextSplit()
define_default( 'RL_MAX_TEXTSPLIT_COUNT'         ,  128 ); // Maximum number of substrings to split: TextSplit()


//------------------------------------------------------------------------------------
// Module: rmodels - Configuration Flags
//------------------------------------------------------------------------------------
// Selected desired model fileformats to be supported for loading
define_default( 'RL_SUPPORT_FILEFORMAT_OBJ'      , str_contains( $_RAYLIB_CONTENT , "\0.obj\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_MTL'      , str_contains( $_RAYLIB_CONTENT , "\0.mtl\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_IQM'      , str_contains( $_RAYLIB_CONTENT , "\0.iqm\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_GLTF'     , str_contains( $_RAYLIB_CONTENT , "\0.gltf;.glb\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_VOX'      , str_contains( $_RAYLIB_CONTENT , "\0.vox\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_M3D'      , str_contains( $_RAYLIB_CONTENT , "\0.m3d\0" ) );
// Support procedural mesh generation functions, uses external par_shapes.h library
// NOTE: Some generated meshes DO NOT include generated texture coordinates
define_default( 'RL_SUPPORT_MESH_GENERATION'     , str_contains( $_RAYLIB_CONTENT , "GenMeshPoly" ) );

// rmodels: Configuration values
//------------------------------------------------------------------------------------
define_default( 'RL_MAX_MATERIAL_MAPS'           ,   12 ); // Maximum number of shader maps supported
define_default( 'RL_MAX_MESH_VERTEX_BUFFERS'     ,    7 ); // Maximum vertex buffers (VBO) per mesh

//------------------------------------------------------------------------------------
// Module: raudio - Configuration Flags
//------------------------------------------------------------------------------------
// Desired audio fileformats to be supported for loading
define_default( 'RL_SUPPORT_FILEFORMAT_WAV'       , str_contains( $_RAYLIB_CONTENT , "\0.wav\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_OGG'       , str_contains( $_RAYLIB_CONTENT , "\0.ogg\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_MP3'       , str_contains( $_RAYLIB_CONTENT , "\0.mp3\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_QOA'       , str_contains( $_RAYLIB_CONTENT , "\0.qoa\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_FLAC'      , str_contains( $_RAYLIB_CONTENT , "\0.flac\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_XM'        , str_contains( $_RAYLIB_CONTENT , "\0.xm\0" ) );
define_default( 'RL_SUPPORT_FILEFORMAT_MOD'       , str_contains( $_RAYLIB_CONTENT , "\0.mod\0" ) );

// raudio: Configuration values
//------------------------------------------------------------------------------------
define_default( 'RL_AUDIO_DEVICE_FORMAT'            , "ma_format_f32" );   // Device output format (miniaudio: float-32bit)
define_default( 'RL_AUDIO_DEVICE_CHANNELS'          ,  2 );   // Device output channels: stereo
define_default( 'RL_AUDIO_DEVICE_SAMPLE_RATE'       ,  0 );   // Device sample rate (device default)

define_default( 'RL_MAX_AUDIO_BUFFER_POOL_CHANNELS' , 16 );  // Maximum number of audio pool channels

//------------------------------------------------------------------------------------
// Module: utils - Configuration Flags
//------------------------------------------------------------------------------------
// Standard file io library (stdio.h) included
define_default( 'RL_SUPPORT_STANDARD_FILEIO'        , true );
// Show TRACELOG() output messages
// NOTE: By default LOG_DEBUG traces not shown
define_default( 'RL_SUPPORT_TRACELOG'               , true );
define_default( 'RL_SUPPORT_TRACELOG_DEBUG'         , FALSE );

// utils: Configuration values
//------------------------------------------------------------------------------------
#define MAX_TRACELOG_MSG_LENGTH       256       // Max length of one trace-log message


unset( $_RAYLIB_CONTENT );

//----------------------------------------------------------------------------------
// Some basic Defines
//----------------------------------------------------------------------------------

define_default( 'RL_PI'      , 3.14159265358979323846 );

define_default( 'RL_DEG2RAD' , (RL_PI/180.0) );
define_default( 'RL_RAD2DEG' , (180.0/RL_PI) );

define_default( 'RL_EPSILON' , 0.000001 );

// Get float vector for Matrix
function RL_MatrixToFloat( object $MAT ) : object { return RL_MatrixToFloatV( $MAT )->v ; }

// Get float vector for Vector3
function RL_Vector3ToFloat( object $VEC ) : object { return RL_Vector3ToFloatV( $VEC )->v ; }


// Some Basic Colors
// NOTE: Custom raylib color palette for amazing visuals on WHITE background
function _RAYLIB_define_colors_when_ready()
{
	define( 'RL_LIGHTGRAY'  , RL_Color( 200, 200, 200, 255 ) );  // Light Gray
	define( 'RL_GRAY'       , RL_Color( 130, 130, 130, 255 ) );  // Gray
	define( 'RL_DARKGRAY'   , RL_Color(  80,  80,  80, 255 ) );  // Dark Gray
	define( 'RL_YELLOW'     , RL_Color( 253, 249,   0, 255 ) );  // Yellow
	define( 'RL_GOLD'       , RL_Color( 255, 203,   0, 255 ) );  // Gold
	define( 'RL_ORANGE'     , RL_Color( 255, 161,   0, 255 ) );  // Orange
	define( 'RL_PINK'       , RL_Color( 255, 109, 194, 255 ) );  // Pink
	define( 'RL_RED'        , RL_Color( 230,  41,  55, 255 ) );  // Red
	define( 'RL_MAROON'     , RL_Color( 190,  33,  55, 255 ) );  // Maroon
	define( 'RL_GREEN'      , RL_Color(   0, 228,  48, 255 ) );  // Green
	define( 'RL_LIME'       , RL_Color(   0, 158,  47, 255 ) );  // Lime
	define( 'RL_DARKGREEN'  , RL_Color(   0, 117,  44, 255 ) );  // Dark Green
	define( 'RL_SKYBLUE'    , RL_Color( 102, 191, 255, 255 ) );  // Sky Blue
	define( 'RL_BLUE'       , RL_Color(   0, 121, 241, 255 ) );  // Blue
	define( 'RL_DARKBLUE'   , RL_Color(   0,  82, 172, 255 ) );  // Dark Blue
	define( 'RL_PURPLE'     , RL_Color( 200, 122, 255, 255 ) );  // Purple
	define( 'RL_VIOLET'     , RL_Color( 135,  60, 190, 255 ) );  // Violet
	define( 'RL_DARKPURPLE' , RL_Color( 112,  31, 126, 255 ) );  // Dark Purple
	define( 'RL_BEIGE'      , RL_Color( 211, 176, 131, 255 ) );  // Beige
	define( 'RL_BROWN'      , RL_Color( 127, 106,  79, 255 ) );  // Brown
	define( 'RL_DARKBROWN'  , RL_Color(  76,  63,  47, 255 ) );  // Dark Brown

	define( 'RL_WHITE'      , RL_Color( 255, 255, 255, 255 ) );  // White
	define( 'RL_BLACK'      , RL_Color(   0,   0,   0, 255 ) );  // Black
	define( 'RL_BLANK'      , RL_Color(   0,   0,   0,   0 ) );  // Blank (Transparent)
	define( 'RL_MAGENTA'    , RL_Color( 255,   0, 255, 255 ) );  // Magenta
	define( 'RL_RAYWHITE'   , RL_Color( 245, 245, 245, 255 ) );  // My own White (raylib logo)
}

//----------------------------------------------------------------------------------
// Structures Definition
//----------------------------------------------------------------------------------

$RAYLIB_H .= <<<'RAYLIB_H'

// NOTE: Helper types to be used instead of array return types for *ToFloat functions
typedef struct float3 {
    float v[3];
} float3;

typedef struct float16 {
    float v[16];
} float16;

// Vector2, 2 components
typedef struct Vector2 {
    float x;                // Vector x component
    float y;                // Vector y component
} Vector2;

// Vector3, 3 components

typedef struct Vector3 {
    float x;                // Vector x component
    float y;                // Vector y component
    float z;                // Vector z component
} Vector3;

// Vector4, 4 components
typedef struct Vector4 {
    float x;                // Vector x component
    float y;                // Vector y component
    float z;                // Vector z component
    float w;                // Vector w component
} Vector4;

// Quaternion, 4 components (Vector4 alias)
typedef Vector4 Quaternion;

// Matrix, 4x4 components, column major, OpenGL style, right-handed
typedef struct Matrix {
    float m0, m4, m8, m12;  // Matrix first row (4 components)
    float m1, m5, m9, m13;  // Matrix second row (4 components)
    float m2, m6, m10, m14; // Matrix third row (4 components)
    float m3, m7, m11, m15; // Matrix fourth row (4 components)
} Matrix;

// Color, 4 components, R8G8B8A8 (32bit)
typedef struct Color {
    unsigned char r;        // Color red value
    unsigned char g;        // Color green value
    unsigned char b;        // Color blue value
    unsigned char a;        // Color alpha value
} Color;

// Rectangle, 4 components
typedef struct Rectangle {
    float x;                // Rectangle top-left corner position x
    float y;                // Rectangle top-left corner position y
    float width;            // Rectangle width
    float height;           // Rectangle height
} Rectangle;

// Image, pixel data stored in CPU memory (RAM)
typedef struct Image {
    void *data;             // Image raw data
    int width;              // Image base width
    int height;             // Image base height
    int mipmaps;            // Mipmap levels, 1 by default
    int format;             // Data format (PixelFormat type)
} Image;

// Texture, tex data stored in GPU memory (VRAM)
typedef struct Texture {
    unsigned int id;        // OpenGL texture id
    int width;              // Texture base width
    int height;             // Texture base height
    int mipmaps;            // Mipmap levels, 1 by default
    int format;             // Data format (PixelFormat type)
} Texture;

// Texture2D, same as Texture
typedef Texture Texture2D;

// TextureCubemap, same as Texture
typedef Texture TextureCubemap;

// RenderTexture, fbo for texture rendering
typedef struct RenderTexture {
    unsigned int id;        // OpenGL framebuffer object id
    Texture texture;        // Color buffer attachment texture
    Texture depth;          // Depth buffer attachment texture
} RenderTexture;

// RenderTexture2D, same as RenderTexture
typedef RenderTexture RenderTexture2D;

// NPatchInfo, n-patch layout info
typedef struct NPatchInfo {
    Rectangle source;       // Texture source rectangle
    int left;               // Left border offset
    int top;                // Top border offset
    int right;              // Right border offset
    int bottom;             // Bottom border offset
    int layout;             // Layout of the n-patch: 3x3, 1x3 or 3x1
} NPatchInfo;

// GlyphInfo, font characters glyphs info
typedef struct GlyphInfo {
    int value;              // Character value (Unicode)
    int offsetX;            // Character offset X when drawing
    int offsetY;            // Character offset Y when drawing
    int advanceX;           // Character advance position X
    Image image;            // Character image data
} GlyphInfo;

// Font, font texture and GlyphInfo array data
typedef struct Font {
    int baseSize;           // Base size (default chars height)
    int glyphCount;         // Number of glyph characters
    int glyphPadding;       // Padding around the glyph characters
    Texture2D texture;      // Texture atlas containing the glyphs
    Rectangle *recs;        // Rectangles in texture for the glyphs
    GlyphInfo *glyphs;      // Glyphs info data
} Font;

// Camera, defines position/orientation in 3d space
typedef struct Camera3D {
    Vector3 position;       // Camera position
    Vector3 target;         // Camera target it looks-at
    Vector3 up;             // Camera up vector (rotation over its axis)
    float fovy;             // Camera field-of-view aperture in Y (degrees) in perspective, used as near plane width in orthographic
    int projection;         // Camera projection: CAMERA_PERSPECTIVE or CAMERA_ORTHOGRAPHIC
} Camera3D;

typedef Camera3D Camera;    // Camera type fallback, defaults to Camera3D

// Camera2D, defines position/orientation in 2d space
typedef struct Camera2D {
    Vector2 offset;         // Camera offset (displacement from target)
    Vector2 target;         // Camera target (rotation and zoom origin)
    float rotation;         // Camera rotation in degrees
    float zoom;             // Camera zoom (scaling), should be 1.0f by default
} Camera2D;

// Mesh, vertex data and vao/vbo
typedef struct Mesh {
    int vertexCount;        // Number of vertices stored in arrays
    int triangleCount;      // Number of triangles stored (indexed or not)

    // Vertex attributes data
    float *vertices;        // Vertex position (XYZ - 3 components per vertex) (shader-location = 0)
    float *texcoords;       // Vertex texture coordinates (UV - 2 components per vertex) (shader-location = 1)
    float *texcoords2;      // Vertex texture second coordinates (UV - 2 components per vertex) (shader-location = 5)
    float *normals;         // Vertex normals (XYZ - 3 components per vertex) (shader-location = 2)
    float *tangents;        // Vertex tangents (XYZW - 4 components per vertex) (shader-location = 4)
    unsigned char *colors;      // Vertex colors (RGBA - 4 components per vertex) (shader-location = 3)
    unsigned short *indices;    // Vertex indices (in case vertex data comes indexed)

    // Animation vertex data
    float *animVertices;    // Animated vertex positions (after bones transformations)
    float *animNormals;     // Animated normals (after bones transformations)
    unsigned char *boneIds; // Vertex bone ids, max 255 bone ids, up to 4 bones influence by vertex (skinning)
    float *boneWeights;     // Vertex bone weight, up to 4 bones influence by vertex (skinning)

    // OpenGL identifiers
    unsigned int vaoId;     // OpenGL Vertex Array Object id
    unsigned int *vboId;    // OpenGL Vertex Buffer Objects id (default vertex data)
} Mesh;

// Shader
typedef struct Shader {
    unsigned int id;        // Shader program id
    int *locs;              // Shader locations array (RL_MAX_SHADER_LOCATIONS)
} Shader;

// MaterialMap
typedef struct MaterialMap {
    Texture2D texture;      // Material map texture
    Color color;            // Material map color
    float value;            // Material map value
} MaterialMap;

// Material, includes shader and maps
typedef struct Material {
    Shader shader;          // Material shader
    MaterialMap *maps;      // Material maps array (MAX_MATERIAL_MAPS)
    float params[4];        // Material generic parameters (if required)
} Material;

// Transform, vertex transformation data
typedef struct Transform {
    Vector3 translation;    // Translation
    Quaternion rotation;    // Rotation
    Vector3 scale;          // Scale
} Transform;

// Bone, skeletal animation bone
typedef struct BoneInfo {
    char name[32];          // Bone name
    int parent;             // Bone parent
} BoneInfo;

// Model, meshes, materials and animation data
typedef struct Model {
    Matrix transform;       // Local transform matrix

    int meshCount;          // Number of meshes
    int materialCount;      // Number of materials
    Mesh *meshes;           // Meshes array
    Material *materials;    // Materials array
    int *meshMaterial;      // Mesh material number

    // Animation data
    int boneCount;          // Number of bones
    BoneInfo *bones;        // Bones information (skeleton)
    Transform *bindPose;    // Bones base transformation (pose)
} Model;

// ModelAnimation
typedef struct ModelAnimation {
    int boneCount;          // Number of bones
    int frameCount;         // Number of animation frames
    BoneInfo *bones;        // Bones information (skeleton)
    Transform **framePoses; // Poses array by frame
} ModelAnimation;

// Ray, ray for raycasting
typedef struct Ray {
    Vector3 position;       // Ray position (origin)
    Vector3 direction;      // Ray direction
} Ray;

// RayCollision, ray hit information
typedef struct RayCollision {
    bool hit;               // Did the ray hit something?
    float distance;         // Distance to the nearest hit
    Vector3 point;          // Point of the nearest hit
    Vector3 normal;         // Surface normal of hit
} RayCollision;

// BoundingBox
typedef struct BoundingBox {
    Vector3 min;            // Minimum vertex box-corner
    Vector3 max;            // Maximum vertex box-corner
} BoundingBox;

// Wave, audio wave data
typedef struct Wave {
    unsigned int frameCount;    // Total number of frames (considering channels)
    unsigned int sampleRate;    // Frequency (samples per second)
    unsigned int sampleSize;    // Bit depth (bits per sample): 8, 16, 32 (24 not supported)
    unsigned int channels;      // Number of channels (1-mono, 2-stereo, ...)
    void *data;                 // Buffer data pointer
} Wave;

// Opaque structs declaration
// NOTE: Actual structs are defined internally in raudio module
typedef struct rAudioBuffer rAudioBuffer;
typedef struct rAudioProcessor rAudioProcessor;

// AudioStream, custom audio stream
typedef struct AudioStream {
    rAudioBuffer *buffer;       // Pointer to internal data used by the audio system
    rAudioProcessor *processor; // Pointer to internal data processor, useful for audio effects

    unsigned int sampleRate;    // Frequency (samples per second)
    unsigned int sampleSize;    // Bit depth (bits per sample): 8, 16, 32 (24 not supported)
    unsigned int channels;      // Number of channels (1-mono, 2-stereo, ...)
} AudioStream;

// Sound
typedef struct Sound {
    AudioStream stream;         // Audio stream
    unsigned int frameCount;    // Total number of frames (considering channels)
} Sound;

// Music, audio stream, anything longer than ~10 seconds should be streamed
typedef struct Music {
    AudioStream stream;         // Audio stream
    unsigned int frameCount;    // Total number of frames (considering channels)
    bool looping;               // Music looping enable

    int ctxType;                // Type of music context (audio filetype)
    void *ctxData;              // Audio context data, depends on type
} Music;

// VrDeviceInfo, Head-Mounted-Display device parameters
typedef struct VrDeviceInfo {
    int hResolution;                // Horizontal resolution in pixels
    int vResolution;                // Vertical resolution in pixels
    float hScreenSize;              // Horizontal size in meters
    float vScreenSize;              // Vertical size in meters
    float vScreenCenter;            // Screen center in meters
    float eyeToScreenDistance;      // Distance between eye and display in meters
    float lensSeparationDistance;   // Lens separation distance in meters
    float interpupillaryDistance;   // IPD (distance between pupils) in meters
    float lensDistortionValues[4];  // Lens distortion constant parameters
    float chromaAbCorrection[4];    // Chromatic aberration correction parameters
} VrDeviceInfo;

// VrStereoConfig, VR stereo rendering configuration for simulator
typedef struct VrStereoConfig {
    Matrix projection[2];           // VR projection matrices (per eye)
    Matrix viewOffset[2];           // VR view offset matrices (per eye)
    float leftLensCenter[2];        // VR left lens center
    float rightLensCenter[2];       // VR right lens center
    float leftScreenCenter[2];      // VR left screen center
    float rightScreenCenter[2];     // VR right screen center
    float scale[2];                 // VR distortion scale
    float scaleIn[2];               // VR distortion scale in
} VrStereoConfig;

// File path list
typedef struct FilePathList {
    unsigned int capacity;          // Filepaths max entries
    unsigned int count;             // Filepaths entries count
    char **paths;                   // Filepaths entries
} FilePathList;

RAYLIB_H;

//----------------------------------------------------------------------------------
// Enumerators Definition
//----------------------------------------------------------------------------------
// System/Window config flags
// NOTE: Every bit registers one state (use it with bit masks)
// By default all flags are set to 0
//typedef enum {
    define( 'RL_FLAG_VSYNC_HINT'         , 0x00000040 );   // Set to try enabling V-Sync on GPU
    define( 'RL_FLAG_FULLSCREEN_MODE'    , 0x00000002 );   // Set to run program in fullscreen
    define( 'RL_FLAG_WINDOW_RESIZABLE'   , 0x00000004 );   // Set to allow resizable window
    define( 'RL_FLAG_WINDOW_UNDECORATED' , 0x00000008 );   // Set to disable window decoration (frame and buttons)
    define( 'RL_FLAG_WINDOW_HIDDEN'      , 0x00000080 );   // Set to hide window
    define( 'RL_FLAG_WINDOW_MINIMIZED'   , 0x00000200 );   // Set to minimize window (iconify)
    define( 'RL_FLAG_WINDOW_MAXIMIZED'   , 0x00000400 );   // Set to maximize window (expanded to monitor)
    define( 'RL_FLAG_WINDOW_UNFOCUSED'   , 0x00000800 );   // Set to window non focused
    define( 'RL_FLAG_WINDOW_TOPMOST'     , 0x00001000 );   // Set to window always on top
    define( 'RL_FLAG_WINDOW_ALWAYS_RUN'  , 0x00000100 );   // Set to allow windows running while minimized
    define( 'RL_FLAG_WINDOW_TRANSPARENT' , 0x00000010 );   // Set to allow transparent framebuffer
    define( 'RL_FLAG_WINDOW_HIGHDPI'     , 0x00002000 );   // Set to support HighDPI
    define( 'RL_FLAG_WINDOW_MOUSE_PASSTHROUGH' , 0x00004000 ); // Set to support mouse passthrough, only supported when FLAG_WINDOW_UNDECORATED
    define( 'RL_FLAG_MSAA_4X_HINT'       , 0x00000020 );   // Set to try enabling MSAA 4X
    define( 'RL_FLAG_INTERLACED_HINT'    , 0x00010000 );   // Set to try enabling interlaced video format (for V3D)
//} ConfigFlags;

// Trace log level
// NOTE: Organized by priority level
//typedef enum {
    define( 'RL_LOG_ALL'    , 0 ); // Display all logs
    define( 'RL_LOG_TRACE'  , 1 ); // Trace logging, intended for internal use only
    define( 'RL_LOG_DEBUG'  , 2 ); // Debug logging, used for internal debugging, it should be disabled on release builds
    define( 'RL_LOG_INFO'   , 3 ); // Info logging, used for program execution info
    define( 'RL_LOG_WARNING', 4 ); // Warning logging, used on recoverable failures
    define( 'RL_LOG_ERROR'  , 5 ); // Error logging, used on unrecoverable failures
    define( 'RL_LOG_FATAL'  , 6 ); // Fatal logging, used to abort program: exit(EXIT_FAILURE)
    define( 'RL_LOG_NONE'   , 7 ); // Disable logging
//} TraceLogLevel;

// Keyboard keys (US keyboard layout)
// NOTE: Use GetKeyPressed() to allow redefining
// required keys for alternative layouts
//typedef enum {
    define( 'RL_KEY_NULL'            , 0 );      // Key: NULL, used for no key pressed
    // Alphanumeric keys
    define( 'RL_KEY_APOSTROPHE'      , 39 );     // Key: '
    define( 'RL_KEY_COMMA'           , 44 );     // Key: ,
    define( 'RL_KEY_MINUS'           , 45 );     // Key: -
    define( 'RL_KEY_PERIOD'          , 46 );     // Key: .
    define( 'RL_KEY_SLASH'           , 47 );     // Key: /
    define( 'RL_KEY_ZERO'            , 48 );     // Key: 0
    define( 'RL_KEY_ONE'             , 49 );     // Key: 1
    define( 'RL_KEY_TWO'             , 50 );     // Key: 2
    define( 'RL_KEY_THREE'           , 51 );     // Key: 3
    define( 'RL_KEY_FOUR'            , 52 );     // Key: 4
    define( 'RL_KEY_FIVE'            , 53 );     // Key: 5
    define( 'RL_KEY_SIX'             , 54 );     // Key: 6
    define( 'RL_KEY_SEVEN'           , 55 );     // Key: 7
    define( 'RL_KEY_EIGHT'           , 56 );     // Key: 8
    define( 'RL_KEY_NINE'            , 57 );     // Key: 9
    define( 'RL_KEY_SEMICOLON'       , 59 );     // Key: ;
    define( 'RL_KEY_EQUAL'           , 61 );     // Key: =
    define( 'RL_KEY_A'               , 65 );     // Key: A | a
    define( 'RL_KEY_B'               , 66 );     // Key: B | b
    define( 'RL_KEY_C'               , 67 );     // Key: C | c
    define( 'RL_KEY_D'               , 68 );     // Key: D | d
    define( 'RL_KEY_E'               , 69 );     // Key: E | e
    define( 'RL_KEY_F'               , 70 );     // Key: F | f
    define( 'RL_KEY_G'               , 71 );     // Key: G | g
    define( 'RL_KEY_H'               , 72 );     // Key: H | h
    define( 'RL_KEY_I'               , 73 );     // Key: I | i
    define( 'RL_KEY_J'               , 74 );     // Key: J | j
    define( 'RL_KEY_K'               , 75 );     // Key: K | k
    define( 'RL_KEY_L'               , 76 );     // Key: L | l
    define( 'RL_KEY_M'               , 77 );     // Key: M | m
    define( 'RL_KEY_N'               , 78 );     // Key: N | n
    define( 'RL_KEY_O'               , 79 );     // Key: O | o
    define( 'RL_KEY_P'               , 80 );     // Key: P | p
    define( 'RL_KEY_Q'               , 81 );     // Key: Q | q
    define( 'RL_KEY_R'               , 82 );     // Key: R | r
    define( 'RL_KEY_S'               , 83 );     // Key: S | s
    define( 'RL_KEY_T'               , 84 );     // Key: T | t
    define( 'RL_KEY_U'               , 85 );     // Key: U | u
    define( 'RL_KEY_V'               , 86 );     // Key: V | v
    define( 'RL_KEY_W'               , 87 );     // Key: W | w
    define( 'RL_KEY_X'               , 88 );     // Key: X | x
    define( 'RL_KEY_Y'               , 89 );     // Key: Y | y
    define( 'RL_KEY_Z'               , 90 );     // Key: Z | z
    define( 'RL_KEY_LEFT_BRACKET'    , 91 );     // Key: [
    define( 'RL_KEY_BACKSLASH'       , 92 );     // Key: '\'
    define( 'RL_KEY_RIGHT_BRACKET'   , 93 );     // Key: ]
    define( 'RL_KEY_GRAVE'           , 96 );     // Key: `
    // Function keys
    define( 'RL_KEY_SPACE'           , 32 );     // Key: Space
    define( 'RL_KEY_ESCAPE'          , 256 );    // Key: Esc
    define( 'RL_KEY_ENTER'           , 257 );    // Key: Enter
    define( 'RL_KEY_TAB'             , 258 );    // Key: Tab
    define( 'RL_KEY_BACKSPACE'       , 259 );    // Key: Backspace
    define( 'RL_KEY_INSERT'          , 260 );    // Key: Ins
    define( 'RL_KEY_DELETE'          , 261 );    // Key: Del
    define( 'RL_KEY_RIGHT'           , 262 );    // Key: Cursor right
    define( 'RL_KEY_LEFT'            , 263 );    // Key: Cursor left
    define( 'RL_KEY_DOWN'            , 264 );    // Key: Cursor down
    define( 'RL_KEY_UP'              , 265 );    // Key: Cursor up
    define( 'RL_KEY_PAGE_UP'         , 266 );    // Key: Page up
    define( 'RL_KEY_PAGE_DOWN'       , 267 );    // Key: Page down
    define( 'RL_KEY_HOME'            , 268 );    // Key: Home
    define( 'RL_KEY_END'             , 269 );    // Key: End
    define( 'RL_KEY_CAPS_LOCK'       , 280 );    // Key: Caps lock
    define( 'RL_KEY_SCROLL_LOCK'     , 281 );    // Key: Scroll down
    define( 'RL_KEY_NUM_LOCK'        , 282 );    // Key: Num lock
    define( 'RL_KEY_PRINT_SCREEN'    , 283 );    // Key: Print screen
    define( 'RL_KEY_PAUSE'           , 284 );    // Key: Pause
    define( 'RL_KEY_F1'              , 290 );    // Key: F1
    define( 'RL_KEY_F2'              , 291 );    // Key: F2
    define( 'RL_KEY_F3'              , 292 );    // Key: F3
    define( 'RL_KEY_F4'              , 293 );    // Key: F4
    define( 'RL_KEY_F5'              , 294 );    // Key: F5
    define( 'RL_KEY_F6'              , 295 );    // Key: F6
    define( 'RL_KEY_F7'              , 296 );    // Key: F7
    define( 'RL_KEY_F8'              , 297 );    // Key: F8
    define( 'RL_KEY_F9'              , 298 );    // Key: F9
    define( 'RL_KEY_F10'             , 299 );    // Key: F10
    define( 'RL_KEY_F11'             , 300 );    // Key: F11
    define( 'RL_KEY_F12'             , 301 );    // Key: F12
    define( 'RL_KEY_LEFT_SHIFT'      , 340 );    // Key: Shift left
    define( 'RL_KEY_LEFT_CONTROL'    , 341 );    // Key: Control left
    define( 'RL_KEY_LEFT_ALT'        , 342 );    // Key: Alt left
    define( 'RL_KEY_LEFT_SUPER'      , 343 );    // Key: Super left
    define( 'RL_KEY_RIGHT_SHIFT'     , 344 );    // Key: Shift right
    define( 'RL_KEY_RIGHT_CONTROL'   , 345 );    // Key: Control right
    define( 'RL_KEY_RIGHT_ALT'       , 346 );    // Key: Alt right
    define( 'RL_KEY_RIGHT_SUPER'     , 347 );    // Key: Super right
    define( 'RL_KEY_KB_MENU'         , 348 );    // Key: KB menu
    // Keypad keys
    define( 'RL_KEY_KP_0'            , 320 );    // Key: Keypad 0
    define( 'RL_KEY_KP_1'            , 321 );    // Key: Keypad 1
    define( 'RL_KEY_KP_2'            , 322 );    // Key: Keypad 2
    define( 'RL_KEY_KP_3'            , 323 );    // Key: Keypad 3
    define( 'RL_KEY_KP_4'            , 324 );    // Key: Keypad 4
    define( 'RL_KEY_KP_5'            , 325 );    // Key: Keypad 5
    define( 'RL_KEY_KP_6'            , 326 );    // Key: Keypad 6
    define( 'RL_KEY_KP_7'            , 327 );    // Key: Keypad 7
    define( 'RL_KEY_KP_8'            , 328 );    // Key: Keypad 8
    define( 'RL_KEY_KP_9'            , 329 );    // Key: Keypad 9
    define( 'RL_KEY_KP_DECIMAL'      , 330 );    // Key: Keypad .
    define( 'RL_KEY_KP_DIVIDE'       , 331 );    // Key: Keypad /
    define( 'RL_KEY_KP_MULTIPLY'     , 332 );    // Key: Keypad *
    define( 'RL_KEY_KP_SUBTRACT'     , 333 );    // Key: Keypad -
    define( 'RL_KEY_KP_ADD'          , 334 );    // Key: Keypad +
    define( 'RL_KEY_KP_ENTER'        , 335 );    // Key: Keypad Enter
    define( 'RL_KEY_KP_EQUAL'        , 336 );    // Key: Keypad =
    // Android key buttons
    define( 'RL_KEY_BACK'            , 4  );     // Key: Android back button
    define( 'RL_KEY_MENU'            , 82 );     // Key: Android menu button
    define( 'RL_KEY_VOLUME_UP'       , 24 );     // Key: Android volume up button
    define( 'RL_KEY_VOLUME_DOWN'     , 25 );     // Key: Android volume down button
//} KeyboardKey;

// Mouse buttons
//typedef enum {
    define( 'RL_MOUSE_BUTTON_LEFT'    , 0 );     // Mouse button left
    define( 'RL_MOUSE_BUTTON_RIGHT'   , 1 );     // Mouse button right
    define( 'RL_MOUSE_BUTTON_MIDDLE'  , 2 );     // Mouse button middle (pressed wheel)
    define( 'RL_MOUSE_BUTTON_SIDE'    , 3 );     // Mouse button side (advanced mouse device)
    define( 'RL_MOUSE_BUTTON_EXTRA'   , 4 );     // Mouse button extra (advanced mouse device)
    define( 'RL_MOUSE_BUTTON_FORWARD' , 5 );     // Mouse button forward (advanced mouse device)
    define( 'RL_MOUSE_BUTTON_BACK'    , 6 );     // Mouse button back (advanced mouse device)
//} MouseButton;

// Add backwards compatibility support for deprecated names
define( 'RL_MOUSE_LEFT_BUTTON'   , RL_MOUSE_BUTTON_LEFT   );
define( 'RL_MOUSE_RIGHT_BUTTON'  , RL_MOUSE_BUTTON_RIGHT  );
define( 'RL_MOUSE_MIDDLE_BUTTON' , RL_MOUSE_BUTTON_MIDDLE );

// Mouse cursor
//typedef enum {
    define( 'RL_MOUSE_CURSOR_DEFAULT'       , 0 );     // Default pointer shape
    define( 'RL_MOUSE_CURSOR_ARROW'         , 1 );     // Arrow shape
    define( 'RL_MOUSE_CURSOR_IBEAM'         , 2 );     // Text writing cursor shape
    define( 'RL_MOUSE_CURSOR_CROSSHAIR'     , 3 );     // Cross shape
    define( 'RL_MOUSE_CURSOR_POINTING_HAND' , 4 );     // Pointing hand cursor
    define( 'RL_MOUSE_CURSOR_RESIZE_EW'     , 5 );     // Horizontal resize/move arrow shape
    define( 'RL_MOUSE_CURSOR_RESIZE_NS'     , 6 );     // Vertical resize/move arrow shape
    define( 'RL_MOUSE_CURSOR_RESIZE_NWSE'   , 7 );     // Top-left to bottom-right diagonal resize/move arrow shape
    define( 'RL_MOUSE_CURSOR_RESIZE_NESW'   , 8 );     // The top-right to bottom-left diagonal resize/move arrow shape
    define( 'RL_MOUSE_CURSOR_RESIZE_ALL'    , 9 );     // The omnidirectional resize/move cursor shape
    define( 'RL_MOUSE_CURSOR_NOT_ALLOWED'   , 10 );     // The operation-not-allowed shape
//} MouseCursor;

// Gamepad buttons
//typedef enum {
    define( 'RL_GAMEPAD_BUTTON_UNKNOWN'         , 0 );   // Unknown button, just for error checking
    define( 'RL_GAMEPAD_BUTTON_LEFT_FACE_UP'    , 1 );   // Gamepad left DPAD up button
    define( 'RL_GAMEPAD_BUTTON_LEFT_FACE_RIGHT' , 2 );   // Gamepad left DPAD right button
    define( 'RL_GAMEPAD_BUTTON_LEFT_FACE_DOWN'  , 3 );   // Gamepad left DPAD down button
    define( 'RL_GAMEPAD_BUTTON_LEFT_FACE_LEFT'  , 4 );   // Gamepad left DPAD left button
    define( 'RL_GAMEPAD_BUTTON_RIGHT_FACE_UP'   , 5 );   // Gamepad right button up (i.e. PS3: Triangle, Xbox: Y)
    define( 'RL_GAMEPAD_BUTTON_RIGHT_FACE_RIGHT', 6 );   // Gamepad right button right (i.e. PS3: Square, Xbox: X)
    define( 'RL_GAMEPAD_BUTTON_RIGHT_FACE_DOWN' , 7 );   // Gamepad right button down (i.e. PS3: Cross, Xbox: A)
    define( 'RL_GAMEPAD_BUTTON_RIGHT_FACE_LEFT' , 8 );   // Gamepad right button left (i.e. PS3: Circle, Xbox: B)
    define( 'RL_GAMEPAD_BUTTON_LEFT_TRIGGER_1'  , 9 );   // Gamepad top/back trigger left (first), it could be a trailing button
    define( 'RL_GAMEPAD_BUTTON_LEFT_TRIGGER_2'  , 10 );  // Gamepad top/back trigger left (second), it could be a trailing button
    define( 'RL_GAMEPAD_BUTTON_RIGHT_TRIGGER_1' , 11 );  // Gamepad top/back trigger right (one), it could be a trailing button
    define( 'RL_GAMEPAD_BUTTON_RIGHT_TRIGGER_2' , 12 );  // Gamepad top/back trigger right (second), it could be a trailing button
    define( 'RL_GAMEPAD_BUTTON_MIDDLE_LEFT'     , 13 );  // Gamepad center buttons, left one (i.e. PS3: Select)
    define( 'RL_GAMEPAD_BUTTON_MIDDLE'          , 14 );  // Gamepad center buttons, middle one (i.e. PS3: PS, Xbox: XBOX)
    define( 'RL_GAMEPAD_BUTTON_MIDDLE_RIGHT'    , 15 );  // Gamepad center buttons, right one (i.e. PS3: Start)
    define( 'RL_GAMEPAD_BUTTON_LEFT_THUMB'      , 16 );  // Gamepad joystick pressed button left
    define( 'RL_GAMEPAD_BUTTON_RIGHT_THUMB'     , 17 );  // Gamepad joystick pressed button right
//} GamepadButton;

// Gamepad axis
//typedef enum {
    define( 'RL_GAMEPAD_AXIS_LEFT_X'        , 0 );     // Gamepad left stick X axis
    define( 'RL_GAMEPAD_AXIS_LEFT_Y'        , 1 );     // Gamepad left stick Y axis
    define( 'RL_GAMEPAD_AXIS_RIGHT_X'       , 2 );     // Gamepad right stick X axis
    define( 'RL_GAMEPAD_AXIS_RIGHT_Y'       , 3 );     // Gamepad right stick Y axis
    define( 'RL_GAMEPAD_AXIS_LEFT_TRIGGER'  , 4 );     // Gamepad back trigger left, pressure level: [1..-1]
    define( 'RL_GAMEPAD_AXIS_RIGHT_TRIGGER' , 5 );     // Gamepad back trigger right, pressure level: [1..-1]
//} GamepadAxis;

// Material map index
//typedef enum {
    define( 'RL_MATERIAL_MAP_ALBEDO'    , 0 );  // Albedo material (same as: MATERIAL_MAP_DIFFUSE)
    define( 'RL_MATERIAL_MAP_METALNESS' , 1 );  // Metalness material (same as: MATERIAL_MAP_SPECULAR)
    define( 'RL_MATERIAL_MAP_NORMAL'    , 2 );  // Normal material
    define( 'RL_MATERIAL_MAP_ROUGHNESS' , 3 );  // Roughness material
    define( 'RL_MATERIAL_MAP_OCCLUSION' , 4 );  // Ambient occlusion material
    define( 'RL_MATERIAL_MAP_EMISSION'  , 5 );  // Emission material
    define( 'RL_MATERIAL_MAP_HEIGHT'    , 6 );  // Heightmap material
    define( 'RL_MATERIAL_MAP_CUBEMAP'   , 7 );  // Cubemap material (NOTE: Uses GL_TEXTURE_CUBE_MAP)
    define( 'RL_MATERIAL_MAP_IRRADIANCE', 8 );  // Irradiance material (NOTE: Uses GL_TEXTURE_CUBE_MAP)
    define( 'RL_MATERIAL_MAP_PREFILTER' , 9 );  // Prefilter material (NOTE: Uses GL_TEXTURE_CUBE_MAP)
    define( 'RL_MATERIAL_MAP_BRDF'      , 10 ); // Brdf material
//} MaterialMapIndex;

define( 'RL_MATERIAL_MAP_DIFFUSE'  , RL_MATERIAL_MAP_ALBEDO    );
define( 'RL_MATERIAL_MAP_SPECULAR' , RL_MATERIAL_MAP_METALNESS );

// Shader location index
//typedef enum {
    define( 'RL_SHADER_LOC_VERTEX_POSITION'  , 0  ); // Shader location: vertex attribute: position
    define( 'RL_SHADER_LOC_VERTEX_TEXCOORD01', 1  ); // Shader location: vertex attribute: texcoord01
    define( 'RL_SHADER_LOC_VERTEX_TEXCOORD02', 2  ); // Shader location: vertex attribute: texcoord02
    define( 'RL_SHADER_LOC_VERTEX_NORMAL'    , 3  ); // Shader location: vertex attribute: normal
    define( 'RL_SHADER_LOC_VERTEX_TANGENT'   , 4  ); // Shader location: vertex attribute: tangent
    define( 'RL_SHADER_LOC_VERTEX_COLOR'     , 5  ); // Shader location: vertex attribute: color
    define( 'RL_SHADER_LOC_MATRIX_MVP'       , 6  ); // Shader location: matrix uniform: model-view-projection
    define( 'RL_SHADER_LOC_MATRIX_VIEW'      , 7  ); // Shader location: matrix uniform: view (camera transform)
    define( 'RL_SHADER_LOC_MATRIX_PROJECTION', 8  ); // Shader location: matrix uniform: projection
    define( 'RL_SHADER_LOC_MATRIX_MODEL'     , 9  ); // Shader location: matrix uniform: model (transform)
    define( 'RL_SHADER_LOC_MATRIX_NORMAL'    , 10 ); // Shader location: matrix uniform: normal
    define( 'RL_SHADER_LOC_VECTOR_VIEW'      , 11 ); // Shader location: vector uniform: view
    define( 'RL_SHADER_LOC_COLOR_DIFFUSE'    , 12 ); // Shader location: vector uniform: diffuse color
    define( 'RL_SHADER_LOC_COLOR_SPECULAR'   , 13 ); // Shader location: vector uniform: specular color
    define( 'RL_SHADER_LOC_COLOR_AMBIENT'    , 14 ); // Shader location: vector uniform: ambient color
    define( 'RL_SHADER_LOC_MAP_ALBEDO'       , 15 ); // Shader location: sampler2d texture: albedo (same as: SHADER_LOC_MAP_DIFFUSE)
    define( 'RL_SHADER_LOC_MAP_METALNESS'    , 16 ); // Shader location: sampler2d texture: metalness (same as: SHADER_LOC_MAP_SPECULAR)
    define( 'RL_SHADER_LOC_MAP_NORMAL'       , 17 ); // Shader location: sampler2d texture: normal
    define( 'RL_SHADER_LOC_MAP_ROUGHNESS'    , 18 ); // Shader location: sampler2d texture: roughness
    define( 'RL_SHADER_LOC_MAP_OCCLUSION'    , 19 ); // Shader location: sampler2d texture: occlusion
    define( 'RL_SHADER_LOC_MAP_EMISSION'     , 20 ); // Shader location: sampler2d texture: emission
    define( 'RL_SHADER_LOC_MAP_HEIGHT'       , 21 ); // Shader location: sampler2d texture: height
    define( 'RL_SHADER_LOC_MAP_CUBEMAP'      , 22 ); // Shader location: samplerCube texture: cubemap
    define( 'RL_SHADER_LOC_MAP_IRRADIANCE'   , 23 ); // Shader location: samplerCube texture: irradiance
    define( 'RL_SHADER_LOC_MAP_PREFILTER'    , 24 ); // Shader location: samplerCube texture: prefilter
    define( 'RL_SHADER_LOC_MAP_BRDF'         , 25 ); // Shader location: sampler2d texture: brdf
//} ShaderLocationIndex;

define( 'RL_SHADER_LOC_MAP_DIFFUSE'  , RL_SHADER_LOC_MAP_ALBEDO    );
define( 'RL_SHADER_LOC_MAP_SPECULAR' , RL_SHADER_LOC_MAP_METALNESS );

// Shader uniform data type
//typedef enum {
    define( 'RL_SHADER_UNIFORM_FLOAT'     , 0 );   // Shader uniform type: float
    define( 'RL_SHADER_UNIFORM_VEC2'      , 1 );   // Shader uniform type: vec2 (2 float)
    define( 'RL_SHADER_UNIFORM_VEC3'      , 2 );   // Shader uniform type: vec3 (3 float)
    define( 'RL_SHADER_UNIFORM_VEC4'      , 3 );   // Shader uniform type: vec4 (4 float)
    define( 'RL_SHADER_UNIFORM_INT'       , 4 );   // Shader uniform type: int
    define( 'RL_SHADER_UNIFORM_IVEC2'     , 5 );   // Shader uniform type: ivec2 (2 int)
    define( 'RL_SHADER_UNIFORM_IVEC3'     , 6 );   // Shader uniform type: ivec3 (3 int)
    define( 'RL_SHADER_UNIFORM_IVEC4'     , 7 );   // Shader uniform type: ivec4 (4 int)
    define( 'RL_SHADER_UNIFORM_SAMPLER2D' , 8 );   // Shader uniform type: sampler2d
//} ShaderUniformDataType;

// Shader attribute data types
//typedef enum {
    define( 'RL_SHADER_ATTRIB_FLOAT' , 0 );   // Shader attribute type: float
    define( 'RL_SHADER_ATTRIB_VEC2'  , 1 );   // Shader attribute type: vec2 (2 float)
    define( 'RL_SHADER_ATTRIB_VEC3'  , 2 );   // Shader attribute type: vec3 (3 float)
    define( 'RL_SHADER_ATTRIB_VEC4'  , 3 );   // Shader attribute type: vec4 (4 float)
//} ShaderAttributeDataType;

// Pixel formats
// NOTE: Support depends on OpenGL version and platform
//typedef enum {
    define( 'RL_PIXELFORMAT_UNCOMPRESSED_GRAYSCALE'   , 1 );  // 8 bit per pixel (no alpha)
    define( 'RL_PIXELFORMAT_UNCOMPRESSED_GRAY_ALPHA'  , 2 );  // 8*2 bpp (2 channels)
    define( 'RL_PIXELFORMAT_UNCOMPRESSED_R5G6B5'      , 3 );  // 16 bpp
    define( 'RL_PIXELFORMAT_UNCOMPRESSED_R8G8B8'      , 4 );  // 24 bpp
    define( 'RL_PIXELFORMAT_UNCOMPRESSED_R5G5B5A1'    , 5 );  // 16 bpp (1 bit alpha)
    define( 'RL_PIXELFORMAT_UNCOMPRESSED_R4G4B4A4'    , 6 );  // 16 bpp (4 bit alpha)
    define( 'RL_PIXELFORMAT_UNCOMPRESSED_R8G8B8A8'    , 7 );  // 32 bpp
    define( 'RL_PIXELFORMAT_UNCOMPRESSED_R32'         , 8 );  // 32 bpp (1 channel - float)
    define( 'RL_PIXELFORMAT_UNCOMPRESSED_R32G32B32'   , 9 );  // 32*3 bpp (3 channels - float)
    define( 'RL_PIXELFORMAT_UNCOMPRESSED_R32G32B32A32', 10 );  // 32*4 bpp (4 channels - float)
    define( 'RL_PIXELFORMAT_COMPRESSED_DXT1_RGB'      , 11 );  // 4 bpp (no alpha)
    define( 'RL_PIXELFORMAT_COMPRESSED_DXT1_RGBA'     , 12 );  // 4 bpp (1 bit alpha)
    define( 'RL_PIXELFORMAT_COMPRESSED_DXT3_RGBA'     , 13 );  // 8 bpp
    define( 'RL_PIXELFORMAT_COMPRESSED_DXT5_RGBA'     , 14 );  // 8 bpp
    define( 'RL_PIXELFORMAT_COMPRESSED_ETC1_RGB'      , 15 );  // 4 bpp
    define( 'RL_PIXELFORMAT_COMPRESSED_ETC2_RGB'      , 16 );  // 4 bpp
    define( 'RL_PIXELFORMAT_COMPRESSED_ETC2_EAC_RGBA' , 17 );  // 8 bpp
    define( 'RL_PIXELFORMAT_COMPRESSED_PVRT_RGB'      , 18 );  // 4 bpp
    define( 'RL_PIXELFORMAT_COMPRESSED_PVRT_RGBA'     , 19 );  // 4 bpp
    define( 'RL_PIXELFORMAT_COMPRESSED_ASTC_4x4_RGBA' , 20 );  // 8 bpp
    define( 'RL_PIXELFORMAT_COMPRESSED_ASTC_8x8_RGBA' , 21 );  // 2 bpp
//} PixelFormat;

// Texture parameters: filter mode
// NOTE 1: Filtering considers mipmaps if available in the texture
// NOTE 2: Filter is accordingly set for minification and magnification
//typedef enum {
    define( 'RL_TEXTURE_FILTER_POINT'          , 0 );  // No filter, just pixel approximation
    define( 'RL_TEXTURE_FILTER_BILINEAR'       , 1 );  // Linear filtering
    define( 'RL_TEXTURE_FILTER_TRILINEAR'      , 2 );  // Trilinear filtering (linear with mipmaps)
    define( 'RL_TEXTURE_FILTER_ANISOTROPIC_4X' , 3 );  // Anisotropic filtering 4x
    define( 'RL_TEXTURE_FILTER_ANISOTROPIC_8X' , 4 );  // Anisotropic filtering 8x
    define( 'RL_TEXTURE_FILTER_ANISOTROPIC_16X', 5 );  // Anisotropic filtering 16x
//} TextureFilter;

// Texture parameters: wrap mode
//typedef enum {
    define( 'RL_TEXTURE_WRAP_REPEAT'       , 0 );  // Repeats texture in tiled mode
    define( 'RL_TEXTURE_WRAP_CLAMP'        , 1 );  // Clamps texture to edge pixel in tiled mode
    define( 'RL_TEXTURE_WRAP_MIRROR_REPEAT', 2 );  // Mirrors and repeats the texture in tiled mode
    define( 'RL_TEXTURE_WRAP_MIRROR_CLAMP' , 3 );  // Mirrors and clamps to border the texture in tiled mode
//} TextureWrap;

// Cubemap layouts
//typedef enum {
    define( 'RL_CUBEMAP_LAYOUT_AUTO_DETECT'        , 0 );   // Automatically detect layout type
    define( 'RL_CUBEMAP_LAYOUT_LINE_VERTICAL'      , 1 );   // Layout is defined by a vertical line with faces
    define( 'RL_CUBEMAP_LAYOUT_LINE_HORIZONTAL'    , 2 );   // Layout is defined by a horizontal line with faces
    define( 'RL_CUBEMAP_LAYOUT_CROSS_THREE_BY_FOUR', 3 );   // Layout is defined by a 3x4 cross with cubemap faces
    define( 'RL_CUBEMAP_LAYOUT_CROSS_FOUR_BY_THREE', 4 );   // Layout is defined by a 4x3 cross with cubemap faces
    define( 'RL_CUBEMAP_LAYOUT_PANORAMA'           , 5 );   // Layout is defined by a panorama image (equirrectangular map)
//} CubemapLayout;

// Font type, defines generation method
//typedef enum {
    define( 'RL_FONT_DEFAULT' , 0 );   // Default font generation, anti-aliased
    define( 'RL_FONT_BITMAP'  , 1 );   // Bitmap font generation, no anti-aliasing
    define( 'RL_FONT_SDF'     , 2 );   // SDF font generation, requires external shader
//} FontType;

// Color blending modes (pre-defined)
//typedef enum {
    define( 'RL_BLEND_ALPHA'            , 0 );    // Blend textures considering alpha (default)
    define( 'RL_BLEND_ADDITIVE'         , 1 );    // Blend textures adding colors
    define( 'RL_BLEND_MULTIPLIED'       , 2 );    // Blend textures multiplying colors
    define( 'RL_BLEND_ADD_COLORS'       , 3 );    // Blend textures adding colors (alternative)
    define( 'RL_BLEND_SUBTRACT_COLORS'  , 4 );    // Blend textures subtracting colors (alternative)
    define( 'RL_BLEND_ALPHA_PREMULTIPLY', 5 );    // Blend premultiplied textures considering alpha
    define( 'RL_BLEND_CUSTOM'           , 6 );    // Blend textures using custom src/dst factors (use rlSetBlendFactors())
    define( 'RL_BLEND_CUSTOM_SEPARATE'  , 7 );    // Blend textures using custom rgb/alpha separate src/dst factors (use rlSetBlendFactorsSeparate())
//} BlendMode;

// Gesture
// NOTE: Provided as bit-wise flags to enable only desired gestures
//typedef enum {
    define( 'RL_GESTURE_NONE'        , 0 );      // No gesture
    define( 'RL_GESTURE_TAP'         , 1 );      // Tap gesture
    define( 'RL_GESTURE_DOUBLETAP'   , 2 );      // Double tap gesture
    define( 'RL_GESTURE_HOLD'        , 4 );      // Hold gesture
    define( 'RL_GESTURE_DRAG'        , 8 );      // Drag gesture
    define( 'RL_GESTURE_SWIPE_RIGHT' , 16 );     // Swipe right gesture
    define( 'RL_GESTURE_SWIPE_LEFT'  , 32 );     // Swipe left gesture
    define( 'RL_GESTURE_SWIPE_UP'    , 64 );     // Swipe up gesture
    define( 'RL_GESTURE_SWIPE_DOWN'  , 128 );    // Swipe down gesture
    define( 'RL_GESTURE_PINCH_IN'    , 256 );    // Pinch in gesture
    define( 'RL_GESTURE_PINCH_OUT'   , 512 );    // Pinch out gesture
//} Gesture;

// Camera system modes
//typedef enum {
    define( 'RL_CAMERA_CUSTOM'      , 0 );   // Custom camera
    define( 'RL_CAMERA_FREE'        , 1 );   // Free camera
    define( 'RL_CAMERA_ORBITAL'     , 2 );   // Orbital camera
    define( 'RL_CAMERA_FIRST_PERSON', 3 );   // First person camera
    define( 'RL_CAMERA_THIRD_PERSON', 4 );   // Third person camera
//} CameraMode;

// Camera projection
//typedef enum {
    define( 'RL_CAMERA_PERSPECTIVE'  , 0 );   // Perspective projection
    define( 'RL_CAMERA_ORTHOGRAPHIC' , 1 );   // Orthographic projection
//} CameraProjection;

// N-patch layout
//typedef enum {
    define( 'RL_NPATCH_NINE_PATCH'            , 0 ); // Npatch layout: 3x3 tiles
    define( 'RL_NPATCH_THREE_PATCH_VERTICAL'  , 1 ); // Npatch layout: 1x3 tiles
    define( 'RL_NPATCH_THREE_PATCH_HORIZONTAL', 2 ); // Npatch layout: 3x1 tiles
//} NPatchLayout;

$RAYLIB_H .= <<<'RAYLIB_H'

// Callbacks to hook some internal functions
// WARNING: These callbacks are intended for advance users

typedef void (*TraceLogCallback)(int logLevel, const char *text, va_list args);  // Logging: Redirect trace log messages
typedef unsigned char *(*LoadFileDataCallback)(const char *fileName, unsigned int *bytesRead);      // FileIO: Load binary data
typedef bool (*SaveFileDataCallback)(const char *fileName, void *data, unsigned int bytesToWrite);  // FileIO: Save binary data
typedef char *(*LoadFileTextCallback)(const char *fileName);            // FileIO: Load text data
typedef bool (*SaveFileTextCallback)(const char *fileName, char *text); // FileIO: Save text data

RAYLIB_H;

//------------------------------------------------------------------------------------
// Global Variables Definition
//------------------------------------------------------------------------------------
// It's lonely here...

//------------------------------------------------------------------------------------
// Window and Graphics Device Functions (Module: core)
//------------------------------------------------------------------------------------

$RAYLIB_H .= <<<'RAYLIB_H'

// Window-related functions
/*RLAPI*/ void InitWindow(int width, int height, const char *title);  // Initialize window and OpenGL context
/*RLAPI*/ bool WindowShouldClose(void);                               // Check if KEY_ESCAPE pressed or Close icon pressed
/*RLAPI*/ void CloseWindow(void);                                     // Close window and unload OpenGL context
/*RLAPI*/ bool IsWindowReady(void);                                   // Check if window has been initialized successfully
/*RLAPI*/ bool IsWindowFullscreen(void);                              // Check if window is currently fullscreen
/*RLAPI*/ bool IsWindowHidden(void);                                  // Check if window is currently hidden (only PLATFORM_DESKTOP)
/*RLAPI*/ bool IsWindowMinimized(void);                               // Check if window is currently minimized (only PLATFORM_DESKTOP)
/*RLAPI*/ bool IsWindowMaximized(void);                               // Check if window is currently maximized (only PLATFORM_DESKTOP)
/*RLAPI*/ bool IsWindowFocused(void);                                 // Check if window is currently focused (only PLATFORM_DESKTOP)
/*RLAPI*/ bool IsWindowResized(void);                                 // Check if window has been resized last frame
/*RLAPI*/ bool IsWindowState(unsigned int flag);                      // Check if one specific window flag is enabled
/*RLAPI*/ void SetWindowState(unsigned int flags);                    // Set window configuration state using flags (only PLATFORM_DESKTOP)
/*RLAPI*/ void ClearWindowState(unsigned int flags);                  // Clear window configuration state flags
/*RLAPI*/ void ToggleFullscreen(void);                                // Toggle window state: fullscreen/windowed (only PLATFORM_DESKTOP)
/*RLAPI*/ void MaximizeWindow(void);                                  // Set window state: maximized, if resizable (only PLATFORM_DESKTOP)
/*RLAPI*/ void MinimizeWindow(void);                                  // Set window state: minimized, if resizable (only PLATFORM_DESKTOP)
/*RLAPI*/ void RestoreWindow(void);                                   // Set window state: not minimized/maximized (only PLATFORM_DESKTOP)
/*RLAPI*/ void SetWindowIcon(Image image);                            // Set icon for window (single image, RGBA 32bit, only PLATFORM_DESKTOP)
/*RLAPI*/ void SetWindowIcons(Image *images, int count);              // Set icon for window (multiple images, RGBA 32bit, only PLATFORM_DESKTOP)
/*RLAPI*/ void SetWindowTitle(const char *title);                     // Set title for window (only PLATFORM_DESKTOP)
/*RLAPI*/ void SetWindowPosition(int x, int y);                       // Set window position on screen (only PLATFORM_DESKTOP)
/*RLAPI*/ void SetWindowMonitor(int monitor);                         // Set monitor for the current window (fullscreen mode)
/*RLAPI*/ void SetWindowMinSize(int width, int height);               // Set window minimum dimensions (for FLAG_WINDOW_RESIZABLE)
/*RLAPI*/ void SetWindowSize(int width, int height);                  // Set window dimensions
/*RLAPI*/ void SetWindowOpacity(float opacity);                       // Set window opacity [0.0f..1.0f] (only PLATFORM_DESKTOP)
/*RLAPI*/ void *GetWindowHandle(void);                                // Get native window handle
/*RLAPI*/ int GetScreenWidth(void);                                   // Get current screen width
/*RLAPI*/ int GetScreenHeight(void);                                  // Get current screen height
/*RLAPI*/ int GetRenderWidth(void);                                   // Get current render width (it considers HiDPI)
/*RLAPI*/ int GetRenderHeight(void);                                  // Get current render height (it considers HiDPI)
/*RLAPI*/ int GetMonitorCount(void);                                  // Get number of connected monitors
/*RLAPI*/ int GetCurrentMonitor(void);                                // Get current connected monitor
/*RLAPI*/ Vector2 GetMonitorPosition(int monitor);                    // Get specified monitor position
/*RLAPI*/ int GetMonitorWidth(int monitor);                           // Get specified monitor width (current video mode used by monitor)
/*RLAPI*/ int GetMonitorHeight(int monitor);                          // Get specified monitor height (current video mode used by monitor)
/*RLAPI*/ int GetMonitorPhysicalWidth(int monitor);                   // Get specified monitor physical width in millimetres
/*RLAPI*/ int GetMonitorPhysicalHeight(int monitor);                  // Get specified monitor physical height in millimetres
/*RLAPI*/ int GetMonitorRefreshRate(int monitor);                     // Get specified monitor refresh rate
/*RLAPI*/ Vector2 GetWindowPosition(void);                            // Get window position XY on monitor
/*RLAPI*/ Vector2 GetWindowScaleDPI(void);                            // Get window scale DPI factor
/*RLAPI*/ const char *GetMonitorName(int monitor);                    // Get the human-readable, UTF-8 encoded name of the primary monitor
/*RLAPI*/ void SetClipboardText(const char *text);                    // Set clipboard text content
/*RLAPI*/ const char *GetClipboardText(void);                         // Get clipboard text content
/*RLAPI*/ void EnableEventWaiting(void);                              // Enable waiting for events on EndDrawing(), no automatic event polling
/*RLAPI*/ void DisableEventWaiting(void);                             // Disable waiting for events on EndDrawing(), automatic events polling

// Custom frame control functions
// NOTE: Those functions are intended for advance users that want full control over the frame processing
// By default EndDrawing() does this job: draws everything + SwapScreenBuffer() + manage frame timing + PollInputEvents()
// To avoid that behaviour and control frame processes manually, enable in config.h: SUPPORT_CUSTOM_FRAME_CONTROL
/*RLAPI*/ void SwapScreenBuffer(void);                                // Swap back buffer with front buffer (screen drawing)
/*RLAPI*/ void PollInputEvents(void);                                 // Register all input events
/*RLAPI*/ void WaitTime(double seconds);                              // Wait for some time (halt program execution)

// Cursor-related functions
/*RLAPI*/ void ShowCursor(void);                                      // Shows cursor
/*RLAPI*/ void HideCursor(void);                                      // Hides cursor
/*RLAPI*/ bool IsCursorHidden(void);                                  // Check if cursor is not visible
/*RLAPI*/ void EnableCursor(void);                                    // Enables cursor (unlock cursor)
/*RLAPI*/ void DisableCursor(void);                                   // Disables cursor (lock cursor)
/*RLAPI*/ bool IsCursorOnScreen(void);                                // Check if cursor is on the screen

// Drawing-related functions
/*RLAPI*/ void ClearBackground(Color color);                          // Set background color (framebuffer clear color)
/*RLAPI*/ void BeginDrawing(void);                                    // Setup canvas (framebuffer) to start drawing
/*RLAPI*/ void EndDrawing(void);                                      // End canvas drawing and swap buffers (double buffering)
/*RLAPI*/ void BeginMode2D(Camera2D camera);                          // Begin 2D mode with custom camera (2D)
/*RLAPI*/ void EndMode2D(void);                                       // Ends 2D mode with custom camera
/*RLAPI*/ void BeginMode3D(Camera3D camera);                          // Begin 3D mode with custom camera (3D)
/*RLAPI*/ void EndMode3D(void);                                       // Ends 3D mode and returns to default 2D orthographic mode
/*RLAPI*/ void BeginTextureMode(RenderTexture2D target);              // Begin drawing to render texture
/*RLAPI*/ void EndTextureMode(void);                                  // Ends drawing to render texture
/*RLAPI*/ void BeginShaderMode(Shader shader);                        // Begin custom shader drawing
/*RLAPI*/ void EndShaderMode(void);                                   // End custom shader drawing (use default shader)
/*RLAPI*/ void BeginBlendMode(int mode);                              // Begin blending mode (alpha, additive, multiplied, subtract, custom)
/*RLAPI*/ void EndBlendMode(void);                                    // End blending mode (reset to default: alpha blending)
/*RLAPI*/ void BeginScissorMode(int x, int y, int width, int height); // Begin scissor mode (define screen area for following drawing)
/*RLAPI*/ void EndScissorMode(void);                                  // End scissor mode
/*RLAPI*/ void BeginVrStereoMode(VrStereoConfig config);              // Begin stereo rendering (requires VR simulator)
/*RLAPI*/ void EndVrStereoMode(void);                                 // End stereo rendering (requires VR simulator)

// VR stereo config functions for VR simulator
/*RLAPI*/ VrStereoConfig LoadVrStereoConfig(VrDeviceInfo device);     // Load VR stereo config for VR simulator device parameters
/*RLAPI*/ void UnloadVrStereoConfig(VrStereoConfig config);           // Unload VR stereo config

// Shader management functions
// NOTE: Shader functionality is not available on OpenGL 1.1
/*RLAPI*/ Shader LoadShader(const char *vsFileName, const char *fsFileName);   // Load shader from files and bind default locations
/*RLAPI*/ Shader LoadShaderFromMemory(const char *vsCode, const char *fsCode); // Load shader from code strings and bind default locations
/*RLAPI*/ bool IsShaderReady(Shader shader);                                   // Check if a shader is ready
/*RLAPI*/ int GetShaderLocation(Shader shader, const char *uniformName);       // Get shader uniform location
/*RLAPI*/ int GetShaderLocationAttrib(Shader shader, const char *attribName);  // Get shader attribute location
/*RLAPI*/ void SetShaderValue(Shader shader, int locIndex, const void *value, int uniformType);               // Set shader uniform value
/*RLAPI*/ void SetShaderValueV(Shader shader, int locIndex, const void *value, int uniformType, int count);   // Set shader uniform value vector
/*RLAPI*/ void SetShaderValueMatrix(Shader shader, int locIndex, Matrix mat);         // Set shader uniform value (matrix 4x4)
/*RLAPI*/ void SetShaderValueTexture(Shader shader, int locIndex, Texture2D texture); // Set shader uniform value for texture (sampler2d)
/*RLAPI*/ void UnloadShader(Shader shader);                                    // Unload shader from GPU memory (VRAM)

// Screen-space-related functions
/*RLAPI*/ Ray GetMouseRay(Vector2 mousePosition, Camera camera);      // Get a ray trace from mouse position
/*RLAPI*/ Matrix GetCameraMatrix(Camera camera);                      // Get camera transform matrix (view matrix)
/*RLAPI*/ Matrix GetCameraMatrix2D(Camera2D camera);                  // Get camera 2d transform matrix
/*RLAPI*/ Vector2 GetWorldToScreen(Vector3 position, Camera camera);  // Get the screen space position for a 3d world space position
/*RLAPI*/ Vector2 GetScreenToWorld2D(Vector2 position, Camera2D camera); // Get the world space position for a 2d camera screen space position
/*RLAPI*/ Vector2 GetWorldToScreenEx(Vector3 position, Camera camera, int width, int height); // Get size position for a 3d world space position
/*RLAPI*/ Vector2 GetWorldToScreen2D(Vector2 position, Camera2D camera); // Get the screen space position for a 2d camera world space position

// Timing-related functions
/*RLAPI*/ void SetTargetFPS(int fps);                                 // Set target FPS (maximum)
/*RLAPI*/ int GetFPS(void);                                           // Get current FPS
/*RLAPI*/ float GetFrameTime(void);                                   // Get time in seconds for last frame drawn (delta time)
/*RLAPI*/ double GetTime(void);                                       // Get elapsed time in seconds since InitWindow()

// Misc. functions
/*RLAPI*/ int GetRandomValue(int min, int max);                       // Get a random value between min and max (both included)
/*RLAPI*/ void SetRandomSeed(unsigned int seed);                      // Set the seed for the random number generator
/*RLAPI*/ void TakeScreenshot(const char *fileName);                  // Takes a screenshot of current screen (filename extension defines format)
/*RLAPI*/ void SetConfigFlags(unsigned int flags);                    // Setup init configuration flags (view FLAGS)

/*RLAPI*/ void TraceLog(int logLevel, const char *text, ...);         // Show trace log messages (LOG_DEBUG, LOG_INFO, LOG_WARNING, LOG_ERROR...)
/*RLAPI*/ void SetTraceLogLevel(int logLevel);                        // Set the current threshold (minimum) log level
/*RLAPI*/ void *MemAlloc(unsigned int size);                          // Internal memory allocator
/*RLAPI*/ void *MemRealloc(void *ptr, unsigned int size);             // Internal memory reallocator
/*RLAPI*/ void MemFree(void *ptr);                                    // Internal memory free

/*RLAPI*/ void OpenURL(const char *url);                              // Open URL with default system browser (if available)

// Set custom callbacks
// WARNING: Callbacks setup is intended for advance users
/*RLAPI*/ void SetTraceLogCallback(TraceLogCallback callback);         // Set custom trace log
/*RLAPI*/ void SetLoadFileDataCallback(LoadFileDataCallback callback); // Set custom file binary data loader
/*RLAPI*/ void SetSaveFileDataCallback(SaveFileDataCallback callback); // Set custom file binary data saver
/*RLAPI*/ void SetLoadFileTextCallback(LoadFileTextCallback callback); // Set custom file text data loader
/*RLAPI*/ void SetSaveFileTextCallback(SaveFileTextCallback callback); // Set custom file text data saver

// Files management functions
/*RLAPI*/ unsigned char *LoadFileData(const char *fileName, unsigned int *bytesRead);       // Load file data as byte array (read)
/*RLAPI*/ void UnloadFileData(unsigned char *data);                   // Unload file data allocated by LoadFileData()
/*RLAPI*/ bool SaveFileData(const char *fileName, void *data, unsigned int bytesToWrite);   // Save data to file from byte array (write), returns true on success
/*RLAPI*/ bool ExportDataAsCode(const unsigned char *data, unsigned int size, const char *fileName); // Export data to code (.h), returns true on success
/*RLAPI*/ char *LoadFileText(const char *fileName);                   // Load text data from file (read), returns a '\0' terminated string
/*RLAPI*/ void UnloadFileText(char *text);                            // Unload file text data allocated by LoadFileText()
/*RLAPI*/ bool SaveFileText(const char *fileName, char *text);        // Save text data to file (write), string must be '\0' terminated, returns true on success
/*RLAPI*/ bool FileExists(const char *fileName);                      // Check if file exists
/*RLAPI*/ bool DirectoryExists(const char *dirPath);                  // Check if a directory path exists
/*RLAPI*/ bool IsFileExtension(const char *fileName, const char *ext); // Check file extension (including point: .png, .wav)
/*RLAPI*/ int GetFileLength(const char *fileName);                    // Get file length in bytes (NOTE: GetFileSize() conflicts with windows.h)
/*RLAPI*/ const char *GetFileExtension(const char *fileName);         // Get pointer to extension for a filename string (includes dot: '.png')
/*RLAPI*/ const char *GetFileName(const char *filePath);              // Get pointer to filename for a path string
/*RLAPI*/ const char *GetFileNameWithoutExt(const char *filePath);    // Get filename string without extension (uses static string)
/*RLAPI*/ const char *GetDirectoryPath(const char *filePath);         // Get full path for a given fileName with path (uses static string)
/*RLAPI*/ const char *GetPrevDirectoryPath(const char *dirPath);      // Get previous directory path for a given path (uses static string)
/*RLAPI*/ const char *GetWorkingDirectory(void);                      // Get current working directory (uses static string)
/*RLAPI*/ const char *GetApplicationDirectory(void);                  // Get the directory if the running application (uses static string)
/*RLAPI*/ bool ChangeDirectory(const char *dir);                      // Change working directory, return true on success
/*RLAPI*/ bool IsPathFile(const char *path);                          // Check if a given path is a file or a directory
/*RLAPI*/ FilePathList LoadDirectoryFiles(const char *dirPath);       // Load directory filepaths
/*RLAPI*/ FilePathList LoadDirectoryFilesEx(const char *basePath, const char *filter, bool scanSubdirs); // Load directory filepaths with extension filtering and recursive directory scan
/*RLAPI*/ void UnloadDirectoryFiles(FilePathList files);              // Unload filepaths
/*RLAPI*/ bool IsFileDropped(void);                                   // Check if a file has been dropped into window
/*RLAPI*/ FilePathList LoadDroppedFiles(void);                        // Load dropped filepaths
/*RLAPI*/ void UnloadDroppedFiles(FilePathList files);                // Unload dropped filepaths
/*RLAPI*/ long GetFileModTime(const char *fileName);                  // Get file modification time (last write time)

// Compression/Encoding functionality
/*RLAPI*/ unsigned char *CompressData(const unsigned char *data, int dataSize, int *compDataSize);        // Compress data (DEFLATE algorithm), memory must be MemFree()
/*RLAPI*/ unsigned char *DecompressData(const unsigned char *compData, int compDataSize, int *dataSize);  // Decompress data (DEFLATE algorithm), memory must be MemFree()
/*RLAPI*/ char *EncodeDataBase64(const unsigned char *data, int dataSize, int *outputSize);               // Encode data to Base64 string, memory must be MemFree()
/*RLAPI*/ unsigned char *DecodeDataBase64(const unsigned char *data, int *outputSize);                    // Decode Base64 string data, memory must be MemFree()

//------------------------------------------------------------------------------------
// Input Handling Functions (Module: core)
//------------------------------------------------------------------------------------

// Input-related functions: keyboard
/*RLAPI*/ bool IsKeyPressed(int key);                             // Check if a key has been pressed once
/*RLAPI*/ bool IsKeyDown(int key);                                // Check if a key is being pressed
/*RLAPI*/ bool IsKeyReleased(int key);                            // Check if a key has been released once
/*RLAPI*/ bool IsKeyUp(int key);                                  // Check if a key is NOT being pressed
/*RLAPI*/ void SetExitKey(int key);                               // Set a custom key to exit program (default is ESC)
/*RLAPI*/ int GetKeyPressed(void);                                // Get key pressed (keycode), call it multiple times for keys queued, returns 0 when the queue is empty
/*RLAPI*/ int GetCharPressed(void);                               // Get char pressed (unicode), call it multiple times for chars queued, returns 0 when the queue is empty

// Input-related functions: gamepads
/*RLAPI*/ bool IsGamepadAvailable(int gamepad);                   // Check if a gamepad is available
/*RLAPI*/ const char *GetGamepadName(int gamepad);                // Get gamepad internal name id
/*RLAPI*/ bool IsGamepadButtonPressed(int gamepad, int button);   // Check if a gamepad button has been pressed once
/*RLAPI*/ bool IsGamepadButtonDown(int gamepad, int button);      // Check if a gamepad button is being pressed
/*RLAPI*/ bool IsGamepadButtonReleased(int gamepad, int button);  // Check if a gamepad button has been released once
/*RLAPI*/ bool IsGamepadButtonUp(int gamepad, int button);        // Check if a gamepad button is NOT being pressed
/*RLAPI*/ int GetGamepadButtonPressed(void);                      // Get the last gamepad button pressed
/*RLAPI*/ int GetGamepadAxisCount(int gamepad);                   // Get gamepad axis count for a gamepad
/*RLAPI*/ float GetGamepadAxisMovement(int gamepad, int axis);    // Get axis movement value for a gamepad axis
/*RLAPI*/ int SetGamepadMappings(const char *mappings);           // Set internal gamepad mappings (SDL_GameControllerDB)

// Input-related functions: mouse
/*RLAPI*/ bool IsMouseButtonPressed(int button);                  // Check if a mouse button has been pressed once
/*RLAPI*/ bool IsMouseButtonDown(int button);                     // Check if a mouse button is being pressed
/*RLAPI*/ bool IsMouseButtonReleased(int button);                 // Check if a mouse button has been released once
/*RLAPI*/ bool IsMouseButtonUp(int button);                       // Check if a mouse button is NOT being pressed
/*RLAPI*/ int GetMouseX(void);                                    // Get mouse position X
/*RLAPI*/ int GetMouseY(void);                                    // Get mouse position Y
/*RLAPI*/ Vector2 GetMousePosition(void);                         // Get mouse position XY
/*RLAPI*/ Vector2 GetMouseDelta(void);                            // Get mouse delta between frames
/*RLAPI*/ void SetMousePosition(int x, int y);                    // Set mouse position XY
/*RLAPI*/ void SetMouseOffset(int offsetX, int offsetY);          // Set mouse offset
/*RLAPI*/ void SetMouseScale(float scaleX, float scaleY);         // Set mouse scaling
/*RLAPI*/ float GetMouseWheelMove(void);                          // Get mouse wheel movement for X or Y, whichever is larger
/*RLAPI*/ Vector2 GetMouseWheelMoveV(void);                       // Get mouse wheel movement for both X and Y
/*RLAPI*/ void SetMouseCursor(int cursor);                        // Set mouse cursor

// Input-related functions: touch
/*RLAPI*/ int GetTouchX(void);                                    // Get touch position X for touch point 0 (relative to screen size)
/*RLAPI*/ int GetTouchY(void);                                    // Get touch position Y for touch point 0 (relative to screen size)
/*RLAPI*/ Vector2 GetTouchPosition(int index);                    // Get touch position XY for a touch point index (relative to screen size)
/*RLAPI*/ int GetTouchPointId(int index);                         // Get touch point identifier for given index
/*RLAPI*/ int GetTouchPointCount(void);                           // Get number of touch points

RAYLIB_H;

if ( RL_SUPPORT_GESTURES_SYSTEM || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
$RAYLIB_H .= <<<'RAYLIB_H'

//------------------------------------------------------------------------------------
// Gestures and Touch Handling Functions (Module: rgestures)
//------------------------------------------------------------------------------------
/*RLAPI*/ void SetGesturesEnabled(unsigned int flags);      // Enable a set of gestures using flags
/*RLAPI*/ bool IsGestureDetected(int gesture);              // Check if a gesture have been detected
/*RLAPI*/ int GetGestureDetected(void);                     // Get latest detected gesture
/*RLAPI*/ float GetGestureHoldDuration(void);               // Get gesture hold time in milliseconds
/*RLAPI*/ Vector2 GetGestureDragVector(void);               // Get gesture drag vector
/*RLAPI*/ float GetGestureDragAngle(void);                  // Get gesture drag angle
/*RLAPI*/ Vector2 GetGesturePinchVector(void);              // Get gesture pinch delta
/*RLAPI*/ float GetGesturePinchAngle(void);                 // Get gesture pinch angle

RAYLIB_H;
} // RL_SUPPORT_GESTURES_SYSTEM

if ( RL_SUPPORT_MODULE_RSHAPES || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
$RAYLIB_H .= <<<'RAYLIB_H'

//------------------------------------------------------------------------------------
// Basic Shapes Drawing Functions (Module: rshapes)
//------------------------------------------------------------------------------------
// Set texture and rectangle to be used on shapes drawing
// NOTE: It can be useful when using basic shapes and one single font,
// defining a font char white rectangle would allow drawing everything in a single draw call
/*RLAPI*/ void SetShapesTexture(Texture2D texture, Rectangle source);       // Set texture and rectangle to be used on shapes drawing

// Basic shapes drawing functions
/*RLAPI*/ void DrawPixel(int posX, int posY, Color color);                                                   // Draw a pixel
/*RLAPI*/ void DrawPixelV(Vector2 position, Color color);                                                    // Draw a pixel (Vector version)
/*RLAPI*/ void DrawLine(int startPosX, int startPosY, int endPosX, int endPosY, Color color);                // Draw a line
/*RLAPI*/ void DrawLineV(Vector2 startPos, Vector2 endPos, Color color);                                     // Draw a line (Vector version)
/*RLAPI*/ void DrawLineEx(Vector2 startPos, Vector2 endPos, float thick, Color color);                       // Draw a line defining thickness
/*RLAPI*/ void DrawLineBezier(Vector2 startPos, Vector2 endPos, float thick, Color color);                   // Draw a line using cubic-bezier curves in-out
/*RLAPI*/ void DrawLineBezierQuad(Vector2 startPos, Vector2 endPos, Vector2 controlPos, float thick, Color color); // Draw line using quadratic bezier curves with a control point
/*RLAPI*/ void DrawLineBezierCubic(Vector2 startPos, Vector2 endPos, Vector2 startControlPos, Vector2 endControlPos, float thick, Color color); // Draw line using cubic bezier curves with 2 control points
/*RLAPI*/ void DrawLineStrip(Vector2 *points, int pointCount, Color color);                                  // Draw lines sequence
/*RLAPI*/ void DrawCircle(int centerX, int centerY, float radius, Color color);                              // Draw a color-filled circle
/*RLAPI*/ void DrawCircleSector(Vector2 center, float radius, float startAngle, float endAngle, int segments, Color color);      // Draw a piece of a circle
/*RLAPI*/ void DrawCircleSectorLines(Vector2 center, float radius, float startAngle, float endAngle, int segments, Color color); // Draw circle sector outline
/*RLAPI*/ void DrawCircleGradient(int centerX, int centerY, float radius, Color color1, Color color2);       // Draw a gradient-filled circle
/*RLAPI*/ void DrawCircleV(Vector2 center, float radius, Color color);                                       // Draw a color-filled circle (Vector version)
/*RLAPI*/ void DrawCircleLines(int centerX, int centerY, float radius, Color color);                         // Draw circle outline
/*RLAPI*/ void DrawEllipse(int centerX, int centerY, float radiusH, float radiusV, Color color);             // Draw ellipse
/*RLAPI*/ void DrawEllipseLines(int centerX, int centerY, float radiusH, float radiusV, Color color);        // Draw ellipse outline
/*RLAPI*/ void DrawRing(Vector2 center, float innerRadius, float outerRadius, float startAngle, float endAngle, int segments, Color color); // Draw ring
/*RLAPI*/ void DrawRingLines(Vector2 center, float innerRadius, float outerRadius, float startAngle, float endAngle, int segments, Color color);    // Draw ring outline
/*RLAPI*/ void DrawRectangle(int posX, int posY, int width, int height, Color color);                        // Draw a color-filled rectangle
/*RLAPI*/ void DrawRectangleV(Vector2 position, Vector2 size, Color color);                                  // Draw a color-filled rectangle (Vector version)
/*RLAPI*/ void DrawRectangleRec(Rectangle rec, Color color);                                                 // Draw a color-filled rectangle
/*RLAPI*/ void DrawRectanglePro(Rectangle rec, Vector2 origin, float rotation, Color color);                 // Draw a color-filled rectangle with pro parameters
/*RLAPI*/ void DrawRectangleGradientV(int posX, int posY, int width, int height, Color color1, Color color2);// Draw a vertical-gradient-filled rectangle
/*RLAPI*/ void DrawRectangleGradientH(int posX, int posY, int width, int height, Color color1, Color color2);// Draw a horizontal-gradient-filled rectangle
/*RLAPI*/ void DrawRectangleGradientEx(Rectangle rec, Color col1, Color col2, Color col3, Color col4);       // Draw a gradient-filled rectangle with custom vertex colors
/*RLAPI*/ void DrawRectangleLines(int posX, int posY, int width, int height, Color color);                   // Draw rectangle outline
/*RLAPI*/ void DrawRectangleLinesEx(Rectangle rec, float lineThick, Color color);                            // Draw rectangle outline with extended parameters
/*RLAPI*/ void DrawRectangleRounded(Rectangle rec, float roundness, int segments, Color color);              // Draw rectangle with rounded edges
/*RLAPI*/ void DrawRectangleRoundedLines(Rectangle rec, float roundness, int segments, float lineThick, Color color); // Draw rectangle with rounded edges outline
/*RLAPI*/ void DrawTriangle(Vector2 v1, Vector2 v2, Vector2 v3, Color color);                                // Draw a color-filled triangle (vertex in counter-clockwise order!)
/*RLAPI*/ void DrawTriangleLines(Vector2 v1, Vector2 v2, Vector2 v3, Color color);                           // Draw triangle outline (vertex in counter-clockwise order!)
/*RLAPI*/ void DrawTriangleFan(Vector2 *points, int pointCount, Color color);                                // Draw a triangle fan defined by points (first vertex is the center)
/*RLAPI*/ void DrawTriangleStrip(Vector2 *points, int pointCount, Color color);                              // Draw a triangle strip defined by points
/*RLAPI*/ void DrawPoly(Vector2 center, int sides, float radius, float rotation, Color color);               // Draw a regular polygon (Vector version)
/*RLAPI*/ void DrawPolyLines(Vector2 center, int sides, float radius, float rotation, Color color);          // Draw a polygon outline of n sides
/*RLAPI*/ void DrawPolyLinesEx(Vector2 center, int sides, float radius, float rotation, float lineThick, Color color); // Draw a polygon outline of n sides with extended parameters

// Basic shapes collision detection functions
/*RLAPI*/ bool CheckCollisionRecs(Rectangle rec1, Rectangle rec2);                                           // Check collision between two rectangles
/*RLAPI*/ bool CheckCollisionCircles(Vector2 center1, float radius1, Vector2 center2, float radius2);        // Check collision between two circles
/*RLAPI*/ bool CheckCollisionCircleRec(Vector2 center, float radius, Rectangle rec);                         // Check collision between circle and rectangle
/*RLAPI*/ bool CheckCollisionPointRec(Vector2 point, Rectangle rec);                                         // Check if point is inside rectangle
/*RLAPI*/ bool CheckCollisionPointCircle(Vector2 point, Vector2 center, float radius);                       // Check if point is inside circle
/*RLAPI*/ bool CheckCollisionPointTriangle(Vector2 point, Vector2 p1, Vector2 p2, Vector2 p3);               // Check if point is inside a triangle
/*RLAPI*/ bool CheckCollisionPointPoly(Vector2 point, Vector2 *points, int pointCount);                      // Check if point is within a polygon described by array of vertices
/*RLAPI*/ bool CheckCollisionLines(Vector2 startPos1, Vector2 endPos1, Vector2 startPos2, Vector2 endPos2, Vector2 *collisionPoint); // Check the collision between two lines defined by two points each, returns collision point by reference
/*RLAPI*/ bool CheckCollisionPointLine(Vector2 point, Vector2 p1, Vector2 p2, int threshold);                // Check if point belongs to line created between two points [p1] and [p2] with defined margin in pixels [threshold]
/*RLAPI*/ Rectangle GetCollisionRec(Rectangle rec1, Rectangle rec2);                                         // Get collision rectangle for two rectangles collision

RAYLIB_H;
}// RL_SUPPORT_MODULE_RSHAPES


if ( RL_SUPPORT_MODULE_RTEXTURES || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
$RAYLIB_H .= <<<'RAYLIB_H'

//------------------------------------------------------------------------------------
// Texture Loading and Drawing Functions (Module: rtextures)
//------------------------------------------------------------------------------------

// Image loading functions
// NOTE: These functions do not require GPU access
/*RLAPI*/ Image LoadImage(const char *fileName);                                                             // Load image from file into CPU memory (RAM)
/*RLAPI*/ Image LoadImageRaw(const char *fileName, int width, int height, int format, int headerSize);       // Load image from RAW file data
/*RLAPI*/ Image LoadImageAnim(const char *fileName, int *frames);                                            // Load image sequence from file (frames appended to image.data)
/*RLAPI*/ Image LoadImageFromMemory(const char *fileType, const unsigned char *fileData, int dataSize);      // Load image from memory buffer, fileType refers to extension: i.e. '.png'
/*RLAPI*/ Image LoadImageFromTexture(Texture2D texture);                                                     // Load image from GPU texture data
/*RLAPI*/ Image LoadImageFromScreen(void);                                                                   // Load image from screen buffer and (screenshot)
/*RLAPI*/ bool IsImageReady(Image image);                                                                    // Check if an image is ready
/*RLAPI*/ void UnloadImage(Image image);                                                                     // Unload image from CPU memory (RAM)
/*RLAPI*/ bool ExportImage(Image image, const char *fileName);                                               // Export image data to file, returns true on success
/*RLAPI*/ bool ExportImageAsCode(Image image, const char *fileName);                                         // Export image as code file defining an array of bytes, returns true on success

RAYLIB_H;

	if ( RL_SUPPORT_IMAGE_GENERATION || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
	$RAYLIB_H .= <<<'RAYLIB_H'

	// Image generation functions
	/*RLAPI*/ Image GenImageColor(int width, int height, Color color);                                           // Generate image: plain color
	/*RLAPI*/ Image GenImageGradientV(int width, int height, Color top, Color bottom);                           // Generate image: vertical gradient
	/*RLAPI*/ Image GenImageGradientH(int width, int height, Color left, Color right);                           // Generate image: horizontal gradient
	/*RLAPI*/ Image GenImageGradientRadial(int width, int height, float density, Color inner, Color outer);      // Generate image: radial gradient
	/*RLAPI*/ Image GenImageChecked(int width, int height, int checksX, int checksY, Color col1, Color col2);    // Generate image: checked
	/*RLAPI*/ Image GenImageWhiteNoise(int width, int height, float factor);                                     // Generate image: white noise
	/*RLAPI*/ Image GenImagePerlinNoise(int width, int height, int offsetX, int offsetY, float scale);           // Generate image: perlin noise
	/*RLAPI*/ Image GenImageCellular(int width, int height, int tileSize);                                       // Generate image: cellular algorithm, bigger tileSize means bigger cells
	/*RLAPI*/ Image GenImageText(int width, int height, const char *text);                                       // Generate image: grayscale image from text data

	RAYLIB_H; }

$RAYLIB_H .= <<<'RAYLIB_H'

// Image manipulation functions
/*RLAPI*/ Image ImageCopy(Image image);                                                                      // Create an image duplicate (useful for transformations)
/*RLAPI*/ Image ImageFromImage(Image image, Rectangle rec);                                                  // Create an image from another image piece
/*RLAPI*/ Image ImageText(const char *text, int fontSize, Color color);                                      // Create an image from text (default font)
/*RLAPI*/ Image ImageTextEx(Font font, const char *text, float fontSize, float spacing, Color tint);         // Create an image from text (custom sprite font)
/*RLAPI*/ void ImageCrop(Image *image, Rectangle crop);                                                      // Crop an image to a defined rectangle
/*RLAPI*/ void ImageFormat(Image *image, int newFormat);                                                     // Convert image data to desired format
/*RLAPI*/ void ImageResizeNN(Image *image, int newWidth,int newHeight);                                      // Resize image (Nearest-Neighbor scaling algorithm)
/*RLAPI*/ void ImageResize(Image *image, int newWidth, int newHeight);                                       // Resize image (Bicubic scaling algorithm)
/*RLAPI*/ void ImageResizeCanvas(Image *image, int newWidth, int newHeight, int offsetX, int offsetY, Color fill);  // Resize canvas and fill with color

RAYLIB_H;

	if ( RL_SUPPORT_IMAGE_MANIPULATION || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
	$RAYLIB_H .= <<<'RAYLIB_H'

	/*RLAPI*/ void ImageToPOT(Image *image, Color fill);                                                         // Convert image to POT (power-of-two)
	/*RLAPI*/ void ImageAlphaCrop(Image *image, float threshold);                                                // Crop image depending on alpha value
	/*RLAPI*/ void ImageAlphaClear(Image *image, Color color, float threshold);                                  // Clear alpha channel to desired color
	/*RLAPI*/ void ImageAlphaMask(Image *image, Image alphaMask);                                                // Apply alpha mask to image
	/*RLAPI*/ void ImageAlphaPremultiply(Image *image);                                                          // Premultiply alpha channel
	/*RLAPI*/ void ImageBlurGaussian(Image *image, int blurSize);                                                // Apply Gaussian blur using a box blur approximation
	/*RLAPI*/ void ImageMipmaps(Image *image);                                                                   // Compute all mipmap levels for a provided image
	/*RLAPI*/ void ImageDither(Image *image, int rBpp, int gBpp, int bBpp, int aBpp);                            // Dither image data to 16bpp or lower (Floyd-Steinberg dithering)
	/*RLAPI*/ void ImageFlipVertical(Image *image);                                                              // Flip image vertically
	/*RLAPI*/ void ImageFlipHorizontal(Image *image);                                                            // Flip image horizontally
	/*RLAPI*/ void ImageRotateCW(Image *image);                                                                  // Rotate image clockwise 90deg
	/*RLAPI*/ void ImageRotateCCW(Image *image);                                                                 // Rotate image counter-clockwise 90deg
	/*RLAPI*/ void ImageColorTint(Image *image, Color color);                                                    // Modify image color: tint
	/*RLAPI*/ void ImageColorInvert(Image *image);                                                               // Modify image color: invert
	/*RLAPI*/ void ImageColorGrayscale(Image *image);                                                            // Modify image color: grayscale
	/*RLAPI*/ void ImageColorContrast(Image *image, float contrast);                                             // Modify image color: contrast (-100 to 100)
	/*RLAPI*/ void ImageColorBrightness(Image *image, int brightness);                                           // Modify image color: brightness (-255 to 255)
	/*RLAPI*/ void ImageColorReplace(Image *image, Color color, Color replace);                                  // Modify image color: replace color

	RAYLIB_H; }

$RAYLIB_H .= <<< 'RAYLIB_H'

/*RLAPI*/ Color *LoadImageColors(Image image);                                                               // Load color data from image as a Color array (RGBA - 32bit)
/*RLAPI*/ Color *LoadImagePalette(Image image, int maxPaletteSize, int *colorCount);                         // Load colors palette from image as a Color array (RGBA - 32bit)
/*RLAPI*/ void UnloadImageColors(Color *colors);                                                             // Unload color data loaded with LoadImageColors()
/*RLAPI*/ void UnloadImagePalette(Color *colors);                                                            // Unload colors palette loaded with LoadImagePalette()
/*RLAPI*/ Rectangle GetImageAlphaBorder(Image image, float threshold);                                       // Get image alpha border rectangle
/*RLAPI*/ Color GetImageColor(Image image, int x, int y);                                                    // Get image pixel color at (x, y) position

// Image drawing functions
// NOTE: Image software-rendering functions (CPU)
/*RLAPI*/ void ImageClearBackground(Image *dst, Color color);                                                // Clear image background with given color
/*RLAPI*/ void ImageDrawPixel(Image *dst, int posX, int posY, Color color);                                  // Draw pixel within an image
/*RLAPI*/ void ImageDrawPixelV(Image *dst, Vector2 position, Color color);                                   // Draw pixel within an image (Vector version)
/*RLAPI*/ void ImageDrawLine(Image *dst, int startPosX, int startPosY, int endPosX, int endPosY, Color color); // Draw line within an image
/*RLAPI*/ void ImageDrawLineV(Image *dst, Vector2 start, Vector2 end, Color color);                          // Draw line within an image (Vector version)
/*RLAPI*/ void ImageDrawCircle(Image *dst, int centerX, int centerY, int radius, Color color);               // Draw a filled circle within an image
/*RLAPI*/ void ImageDrawCircleV(Image *dst, Vector2 center, int radius, Color color);                        // Draw a filled circle within an image (Vector version)
/*RLAPI*/ void ImageDrawCircleLines(Image *dst, int centerX, int centerY, int radius, Color color);          // Draw circle outline within an image
/*RLAPI*/ void ImageDrawCircleLinesV(Image *dst, Vector2 center, int radius, Color color);                   // Draw circle outline within an image (Vector version)
/*RLAPI*/ void ImageDrawRectangle(Image *dst, int posX, int posY, int width, int height, Color color);       // Draw rectangle within an image
/*RLAPI*/ void ImageDrawRectangleV(Image *dst, Vector2 position, Vector2 size, Color color);                 // Draw rectangle within an image (Vector version)
/*RLAPI*/ void ImageDrawRectangleRec(Image *dst, Rectangle rec, Color color);                                // Draw rectangle within an image
/*RLAPI*/ void ImageDrawRectangleLines(Image *dst, Rectangle rec, int thick, Color color);                   // Draw rectangle lines within an image
/*RLAPI*/ void ImageDraw(Image *dst, Image src, Rectangle srcRec, Rectangle dstRec, Color tint);             // Draw a source image within a destination image (tint applied to source)
/*RLAPI*/ void ImageDrawText(Image *dst, const char *text, int posX, int posY, int fontSize, Color color);   // Draw text (using default font) within an image (destination)
/*RLAPI*/ void ImageDrawTextEx(Image *dst, Font font, const char *text, Vector2 position, float fontSize, float spacing, Color tint); // Draw text (custom sprite font) within an image (destination)

// Texture loading functions
// NOTE: These functions require GPU access
/*RLAPI*/ Texture2D LoadTexture(const char *fileName);                                                       // Load texture from file into GPU memory (VRAM)
/*RLAPI*/ Texture2D LoadTextureFromImage(Image image);                                                       // Load texture from image data
/*RLAPI*/ TextureCubemap LoadTextureCubemap(Image image, int layout);                                        // Load cubemap from image, multiple image cubemap layouts supported
/*RLAPI*/ RenderTexture2D LoadRenderTexture(int width, int height);                                          // Load texture for rendering (framebuffer)
/*RLAPI*/ bool IsTextureReady(Texture2D texture);                                                            // Check if a texture is ready
/*RLAPI*/ void UnloadTexture(Texture2D texture);                                                             // Unload texture from GPU memory (VRAM)
/*RLAPI*/ bool IsRenderTextureReady(RenderTexture2D target);                                                       // Check if a render texture is ready
/*RLAPI*/ void UnloadRenderTexture(RenderTexture2D target);                                                  // Unload render texture from GPU memory (VRAM)
/*RLAPI*/ void UpdateTexture(Texture2D texture, const void *pixels);                                         // Update GPU texture with new data
/*RLAPI*/ void UpdateTextureRec(Texture2D texture, Rectangle rec, const void *pixels);                       // Update GPU texture rectangle with new data

// Texture configuration functions
/*RLAPI*/ void GenTextureMipmaps(Texture2D *texture);                                                        // Generate GPU mipmaps for a texture
/*RLAPI*/ void SetTextureFilter(Texture2D texture, int filter);                                              // Set texture scaling filter mode
/*RLAPI*/ void SetTextureWrap(Texture2D texture, int wrap);                                                  // Set texture wrapping mode

// Texture drawing functions
/*RLAPI*/ void DrawTexture(Texture2D texture, int posX, int posY, Color tint);                               // Draw a Texture2D
/*RLAPI*/ void DrawTextureV(Texture2D texture, Vector2 position, Color tint);                                // Draw a Texture2D with position defined as Vector2
/*RLAPI*/ void DrawTextureEx(Texture2D texture, Vector2 position, float rotation, float scale, Color tint);  // Draw a Texture2D with extended parameters
/*RLAPI*/ void DrawTextureRec(Texture2D texture, Rectangle source, Vector2 position, Color tint);            // Draw a part of a texture defined by a rectangle
/*RLAPI*/ void DrawTexturePro(Texture2D texture, Rectangle source, Rectangle dest, Vector2 origin, float rotation, Color tint); // Draw a part of a texture defined by a rectangle with 'pro' parameters
/*RLAPI*/ void DrawTextureNPatch(Texture2D texture, NPatchInfo nPatchInfo, Rectangle dest, Vector2 origin, float rotation, Color tint); // Draws a texture (or part of it) that stretches or shrinks nicely

// Color/pixel related functions
/*RLAPI*/ Color Fade(Color color, float alpha);                                 // Get color with alpha applied, alpha goes from 0.0f to 1.0f
/*RLAPI*/ int ColorToInt(Color color);                                          // Get hexadecimal value for a Color
/*RLAPI*/ Vector4 ColorNormalize(Color color);                                  // Get Color normalized as float [0..1]
/*RLAPI*/ Color ColorFromNormalized(Vector4 normalized);                        // Get Color from normalized values [0..1]
/*RLAPI*/ Vector3 ColorToHSV(Color color);                                      // Get HSV values for a Color, hue [0..360], saturation/value [0..1]
/*RLAPI*/ Color ColorFromHSV(float hue, float saturation, float value);         // Get a Color from HSV values, hue [0..360], saturation/value [0..1]
/*RLAPI*/ Color ColorTint(Color color, Color tint);                             // Get color multiplied with another color
/*RLAPI*/ Color ColorBrightness(Color color, float factor);                     // Get color with brightness correction, brightness factor goes from -1.0f to 1.0f
/*RLAPI*/ Color ColorContrast(Color color, float contrast);                     // Get color with contrast correction, contrast values between -1.0f and 1.0f
/*RLAPI*/ Color ColorAlpha(Color color, float alpha);                           // Get color with alpha applied, alpha goes from 0.0f to 1.0f
/*RLAPI*/ Color ColorAlphaBlend(Color dst, Color src, Color tint);              // Get src alpha-blended into dst color with tint
/*RLAPI*/ Color GetColor(unsigned int hexValue);                                // Get Color structure from hexadecimal value
/*RLAPI*/ Color GetPixelColor(void *srcPtr, int format);                        // Get Color from a source pixel pointer of certain format
/*RLAPI*/ void SetPixelColor(void *dstPtr, Color color, int format);            // Set color formatted into destination pixel pointer
/*RLAPI*/ int GetPixelDataSize(int width, int height, int format);              // Get pixel data size in bytes for certain format

RAYLIB_H;
} // RL_SUPPORT_MODULE_RTEXTURES

if ( RL_SUPPORT_MODULE_RTEXT || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
$RAYLIB_H .= <<<'RAYLIB_H'

//------------------------------------------------------------------------------------
// Font Loading and Text Drawing Functions (Module: rtext)
//------------------------------------------------------------------------------------

// Font loading/unloading functions
/*RLAPI*/ Font GetFontDefault(void);                                                            // Get the default Font
/*RLAPI*/ Font LoadFont(const char *fileName);                                                  // Load font from file into GPU memory (VRAM)
/*RLAPI*/ Font LoadFontEx(const char *fileName, int fontSize, int *fontChars, int glyphCount);  // Load font from file with extended parameters, use NULL for fontChars and 0 for glyphCount to load the default character set
/*RLAPI*/ Font LoadFontFromImage(Image image, Color key, int firstChar);                        // Load font from Image (XNA style)
/*RLAPI*/ Font LoadFontFromMemory(const char *fileType, const unsigned char *fileData, int dataSize, int fontSize, int *fontChars, int glyphCount); // Load font from memory buffer, fileType refers to extension: i.e. '.ttf'
/*RLAPI*/ bool IsFontReady(Font font);                                                          // Check if a font is ready
/*RLAPI*/ GlyphInfo *LoadFontData(const unsigned char *fileData, int dataSize, int fontSize, int *fontChars, int glyphCount, int type); // Load font data for further use
/*RLAPI*/ Image GenImageFontAtlas(const GlyphInfo *chars, Rectangle **recs, int glyphCount, int fontSize, int padding, int packMethod); // Generate image font atlas using chars info
/*RLAPI*/ void UnloadFontData(GlyphInfo *chars, int glyphCount);                                // Unload font chars info data (RAM)
/*RLAPI*/ void UnloadFont(Font font);                                                           // Unload font from GPU memory (VRAM)
/*RLAPI*/ bool ExportFontAsCode(Font font, const char *fileName);                               // Export font as code file, returns true on success

// Text drawing functions
/*RLAPI*/ void DrawFPS(int posX, int posY);                                                     // Draw current FPS
/*RLAPI*/ void DrawText(const char *text, int posX, int posY, int fontSize, Color color);       // Draw text (using default font)
/*RLAPI*/ void DrawTextEx(Font font, const char *text, Vector2 position, float fontSize, float spacing, Color tint); // Draw text using font and additional parameters
/*RLAPI*/ void DrawTextPro(Font font, const char *text, Vector2 position, Vector2 origin, float rotation, float fontSize, float spacing, Color tint); // Draw text using Font and pro parameters (rotation)
/*RLAPI*/ void DrawTextCodepoint(Font font, int codepoint, Vector2 position, float fontSize, Color tint); // Draw one character (codepoint)
/*RLAPI*/ void DrawTextCodepoints(Font font, const int *codepoints, int count, Vector2 position, float fontSize, float spacing, Color tint); // Draw multiple character (codepoint)

// Text font info functions
/*RLAPI*/ int MeasureText(const char *text, int fontSize);                                      // Measure string width for default font
/*RLAPI*/ Vector2 MeasureTextEx(Font font, const char *text, float fontSize, float spacing);    // Measure string size for Font
/*RLAPI*/ int GetGlyphIndex(Font font, int codepoint);                                          // Get glyph index position in font for a codepoint (unicode character), fallback to '?' if not found
/*RLAPI*/ GlyphInfo GetGlyphInfo(Font font, int codepoint);                                     // Get glyph font info data for a codepoint (unicode character), fallback to '?' if not found
/*RLAPI*/ Rectangle GetGlyphAtlasRec(Font font, int codepoint);                                 // Get glyph rectangle in font atlas for a codepoint (unicode character), fallback to '?' if not found

// Text codepoints management functions (unicode characters)
/*RLAPI*/ int GetCodepoint(const char *text, int *codepointSize);           // Get next codepoint in a UTF-8 encoded string, 0x3f('?') is returned on failure
/*RLAPI*/ int GetCodepointNext(const char *text, int *codepointSize);       // Get next codepoint in a UTF-8 encoded string, 0x3f('?') is returned on failure
/*RLAPI*/ int GetCodepointPrevious(const char *text, int *codepointSize);   // Get previous codepoint in a UTF-8 encoded string, 0x3f('?') is returned on failure

RAYLIB_H;

	if ( RL_SUPPORT_TEXT_MANIPULATION || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
	$RAYLIB_H .= <<<'RAYLIB_H'

		/*RLAPI*/ char *LoadUTF8(const int *codepoints, int length);                // Load UTF-8 text encoded from codepoints array
		/*RLAPI*/ void UnloadUTF8(char *text);                                      // Unload UTF-8 text encoded from codepoints array
		/*RLAPI*/ int *LoadCodepoints(const char *text, int *count);                // Load all codepoints from a UTF-8 text string, codepoints count returned by parameter
		/*RLAPI*/ void UnloadCodepoints(int *codepoints);                           // Unload codepoints data from memory
		/*RLAPI*/ int GetCodepointCount(const char *text);                          // Get total number of codepoints in a UTF-8 encoded string
		/*RLAPI*/ const char *CodepointToUTF8(int codepoint, int *utf8Size);        // Encode one codepoint into UTF-8 byte array (array length returned as parameter)

		// Text strings management functions (no UTF-8 strings, only byte chars)
		// NOTE: Some strings allocate memory internally for returned strings, just be careful!

		/*RLAPI*/ int TextCopy(char *dst, const char *src);                                             // Copy one string to another, returns bytes copied
		/*RLAPI*/ bool TextIsEqual(const char *text1, const char *text2);                               // Check if two text string are equal
		/*RLAPI*/ const char *TextSubtext(const char *text, int position, int length);                  // Get a piece of a text string
		/*RLAPI*/ char *TextReplace(char *text, const char *replace, const char *by);                   // Replace text string (WARNING: memory must be freed!)
		/*RLAPI*/ char *TextInsert(const char *text, const char *insert, int position);                 // Insert text in a position (WARNING: memory must be freed!)
		/*RLAPI*/ const char *TextJoin(const char **textList, int count, const char *delimiter);        // Join text strings with delimiter
		/*RLAPI*/ const char **TextSplit(const char *text, char delimiter, int *count);                 // Split text into multiple strings
		/*RLAPI*/ void TextAppend(char *text, const char *append, int *position);                       // Append text at specific position and move cursor!
		/*RLAPI*/ int TextFindIndex(const char *text, const char *find);                                // Find first text occurrence within a string
		/*RLAPI*/ const char *TextToUpper(const char *text);                      // Get upper case version of provided string
		/*RLAPI*/ const char *TextToLower(const char *text);                      // Get lower case version of provided string
		/*RLAPI*/ const char *TextToPascal(const char *text);                     // Get Pascal case notation version of provided string

	RAYLIB_H; } // RL_SUPPORT_TEXT_MANIPULATION

$RAYLIB_H .= <<<'RAYLIB_H'

/*RLAPI*/ unsigned int TextLength(const char *text);                                            // Get text length, checks for '\0' ending
/*RLAPI*/ const char *TextFormat(const char *text, ...);                                        // Text formatting with variables (sprintf() style)


/*RLAPI*/ int TextToInteger(const char *text);                            // Get integer value from text (negative values not supported)

RAYLIB_H;
} // RL_SUPPORT_MODULE_RTEXT

if ( RL_SUPPORT_MODULE_RMODELS || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
$RAYLIB_H .= <<<'RAYLIB_H'

//------------------------------------------------------------------------------------
// Basic 3d Shapes Drawing Functions (Module: rmodels)
//------------------------------------------------------------------------------------

// Basic geometric 3D shapes drawing functions
/*RLAPI*/ void DrawLine3D(Vector3 startPos, Vector3 endPos, Color color);                                    // Draw a line in 3D world space
/*RLAPI*/ void DrawPoint3D(Vector3 position, Color color);                                                   // Draw a point in 3D space, actually a small line
/*RLAPI*/ void DrawCircle3D(Vector3 center, float radius, Vector3 rotationAxis, float rotationAngle, Color color); // Draw a circle in 3D world space
/*RLAPI*/ void DrawTriangle3D(Vector3 v1, Vector3 v2, Vector3 v3, Color color);                              // Draw a color-filled triangle (vertex in counter-clockwise order!)
/*RLAPI*/ void DrawTriangleStrip3D(Vector3 *points, int pointCount, Color color);                            // Draw a triangle strip defined by points
/*RLAPI*/ void DrawCube(Vector3 position, float width, float height, float length, Color color);             // Draw cube
/*RLAPI*/ void DrawCubeV(Vector3 position, Vector3 size, Color color);                                       // Draw cube (Vector version)
/*RLAPI*/ void DrawCubeWires(Vector3 position, float width, float height, float length, Color color);        // Draw cube wires
/*RLAPI*/ void DrawCubeWiresV(Vector3 position, Vector3 size, Color color);                                  // Draw cube wires (Vector version)
/*RLAPI*/ void DrawSphere(Vector3 centerPos, float radius, Color color);                                     // Draw sphere
/*RLAPI*/ void DrawSphereEx(Vector3 centerPos, float radius, int rings, int slices, Color color);            // Draw sphere with extended parameters
/*RLAPI*/ void DrawSphereWires(Vector3 centerPos, float radius, int rings, int slices, Color color);         // Draw sphere wires
/*RLAPI*/ void DrawCylinder(Vector3 position, float radiusTop, float radiusBottom, float height, int slices, Color color); // Draw a cylinder/cone
/*RLAPI*/ void DrawCylinderEx(Vector3 startPos, Vector3 endPos, float startRadius, float endRadius, int sides, Color color); // Draw a cylinder with base at startPos and top at endPos
/*RLAPI*/ void DrawCylinderWires(Vector3 position, float radiusTop, float radiusBottom, float height, int slices, Color color); // Draw a cylinder/cone wires
/*RLAPI*/ void DrawCylinderWiresEx(Vector3 startPos, Vector3 endPos, float startRadius, float endRadius, int sides, Color color); // Draw a cylinder wires with base at startPos and top at endPos
/*RLAPI*/ void DrawCapsule(Vector3 startPos, Vector3 endPos, float radius, int slices, int rings, Color color); // Draw a capsule with the center of its sphere caps at startPos and endPos
/*RLAPI*/ void DrawCapsuleWires(Vector3 startPos, Vector3 endPos, float radius, int slices, int rings, Color color); // Draw capsule wireframe with the center of its sphere caps at startPos and endPos
/*RLAPI*/ void DrawPlane(Vector3 centerPos, Vector2 size, Color color);                                      // Draw a plane XZ
/*RLAPI*/ void DrawRay(Ray ray, Color color);                                                                // Draw a ray line
/*RLAPI*/ void DrawGrid(int slices, float spacing);                                                          // Draw a grid (centered at (0, 0, 0))

//------------------------------------------------------------------------------------
// Model 3d Loading and Drawing Functions (Module: rmodels)
//------------------------------------------------------------------------------------

// Model management functions
/*RLAPI*/ Model LoadModel(const char *fileName);                                                // Load model from files (meshes and materials)
/*RLAPI*/ Model LoadModelFromMesh(Mesh mesh);                                                   // Load model from generated mesh (default material)
/*RLAPI*/ bool IsModelReady(Model model);                                                       // Check if a model is ready
/*RLAPI*/ void UnloadModel(Model model);                                                        // Unload model (including meshes) from memory (RAM and/or VRAM)
/*RLAPI*/ BoundingBox GetModelBoundingBox(Model model);                                         // Compute model bounding box limits (considers all meshes)

// Model drawing functions
/*RLAPI*/ void DrawModel(Model model, Vector3 position, float scale, Color tint);               // Draw a model (with texture if set)
/*RLAPI*/ void DrawModelEx(Model model, Vector3 position, Vector3 rotationAxis, float rotationAngle, Vector3 scale, Color tint); // Draw a model with extended parameters
/*RLAPI*/ void DrawModelWires(Model model, Vector3 position, float scale, Color tint);          // Draw a model wires (with texture if set)
/*RLAPI*/ void DrawModelWiresEx(Model model, Vector3 position, Vector3 rotationAxis, float rotationAngle, Vector3 scale, Color tint); // Draw a model wires (with texture if set) with extended parameters
/*RLAPI*/ void DrawBoundingBox(BoundingBox box, Color color);                                   // Draw bounding box (wires)
/*RLAPI*/ void DrawBillboard(Camera camera, Texture2D texture, Vector3 position, float size, Color tint);   // Draw a billboard texture
/*RLAPI*/ void DrawBillboardRec(Camera camera, Texture2D texture, Rectangle source, Vector3 position, Vector2 size, Color tint); // Draw a billboard texture defined by source
/*RLAPI*/ void DrawBillboardPro(Camera camera, Texture2D texture, Rectangle source, Vector3 position, Vector3 up, Vector2 size, Vector2 origin, float rotation, Color tint); // Draw a billboard texture defined by source and rotation

// Mesh management functions
/*RLAPI*/ void UploadMesh(Mesh *mesh, bool dynamic);                                            // Upload mesh vertex data in GPU and provide VAO/VBO ids
/*RLAPI*/ void UpdateMeshBuffer(Mesh mesh, int index, const void *data, int dataSize, int offset); // Update mesh vertex data in GPU for a specific buffer index
/*RLAPI*/ void UnloadMesh(Mesh mesh);                                                           // Unload mesh data from CPU and GPU
/*RLAPI*/ void DrawMesh(Mesh mesh, Material material, Matrix transform);                        // Draw a 3d mesh with material and transform
/*RLAPI*/ void DrawMeshInstanced(Mesh mesh, Material material, const Matrix *transforms, int instances); // Draw multiple mesh instances with material and different transforms
/*RLAPI*/ bool ExportMesh(Mesh mesh, const char *fileName);                                     // Export mesh data to file, returns true on success
/*RLAPI*/ BoundingBox GetMeshBoundingBox(Mesh mesh);                                            // Compute mesh bounding box limits
/*RLAPI*/ void GenMeshTangents(Mesh *mesh);                                                     // Compute mesh tangents

RAYLIB_H;

	if ( RL_SUPPORT_MESH_GENERATION || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
	$RAYLIB_H .=<<<'RAYLIB_H'
		// Mesh generation functions
		/*RLAPI*/ Mesh GenMeshPoly(int sides, float radius);                                            // Generate polygonal mesh
		/*RLAPI*/ Mesh GenMeshPlane(float width, float length, int resX, int resZ);                     // Generate plane mesh (with subdivisions)
		/*RLAPI*/ Mesh GenMeshCube(float width, float height, float length);                            // Generate cuboid mesh
		/*RLAPI*/ Mesh GenMeshSphere(float radius, int rings, int slices);                              // Generate sphere mesh (standard sphere)
		/*RLAPI*/ Mesh GenMeshHemiSphere(float radius, int rings, int slices);                          // Generate half-sphere mesh (no bottom cap)
		/*RLAPI*/ Mesh GenMeshCylinder(float radius, float height, int slices);                         // Generate cylinder mesh
		/*RLAPI*/ Mesh GenMeshCone(float radius, float height, int slices);                             // Generate cone/pyramid mesh
		/*RLAPI*/ Mesh GenMeshTorus(float radius, float size, int radSeg, int sides);                   // Generate torus mesh
		/*RLAPI*/ Mesh GenMeshKnot(float radius, float size, int radSeg, int sides);                    // Generate trefoil knot mesh
		/*RLAPI*/ Mesh GenMeshHeightmap(Image heightmap, Vector3 size);                                 // Generate heightmap mesh from image data
		/*RLAPI*/ Mesh GenMeshCubicmap(Image cubicmap, Vector3 cubeSize);                               // Generate cubes-based map mesh from image data
	RAYLIB_H; }

$RAYLIB_H .=<<<'RAYLIB_H'

// Material loading/unloading functions
/*RLAPI*/ Material *LoadMaterials(const char *fileName, int *materialCount);                    // Load materials from model file
/*RLAPI*/ Material LoadMaterialDefault(void);                                                   // Load default material (Supports: DIFFUSE, SPECULAR, NORMAL maps)
/*RLAPI*/ bool IsMaterialReady(Material material);                                              // Check if a material is ready
/*RLAPI*/ void UnloadMaterial(Material material);                                               // Unload material from GPU memory (VRAM)
/*RLAPI*/ void SetMaterialTexture(Material *material, int mapType, Texture2D texture);          // Set texture for a material map type (MATERIAL_MAP_DIFFUSE, MATERIAL_MAP_SPECULAR...)
/*RLAPI*/ void SetModelMeshMaterial(Model *model, int meshId, int materialId);                  // Set material for a mesh

// Model animations loading/unloading functions
/*RLAPI*/ ModelAnimation *LoadModelAnimations(const char *fileName, unsigned int *animCount);   // Load model animations from file
/*RLAPI*/ void UpdateModelAnimation(Model model, ModelAnimation anim, int frame);               // Update model animation pose
/*RLAPI*/ void UnloadModelAnimation(ModelAnimation anim);                                       // Unload animation data
/*RLAPI*/ void UnloadModelAnimations(ModelAnimation *animations, unsigned int count);           // Unload animation array data
/*RLAPI*/ bool IsModelAnimationValid(Model model, ModelAnimation anim);                         // Check model animation skeleton match

// Collision detection functions
/*RLAPI*/ bool CheckCollisionSpheres(Vector3 center1, float radius1, Vector3 center2, float radius2);   // Check collision between two spheres
/*RLAPI*/ bool CheckCollisionBoxes(BoundingBox box1, BoundingBox box2);                                 // Check collision between two bounding boxes
/*RLAPI*/ bool CheckCollisionBoxSphere(BoundingBox box, Vector3 center, float radius);                  // Check collision between box and sphere
/*RLAPI*/ RayCollision GetRayCollisionSphere(Ray ray, Vector3 center, float radius);                    // Get collision info between ray and sphere
/*RLAPI*/ RayCollision GetRayCollisionBox(Ray ray, BoundingBox box);                                    // Get collision info between ray and box
/*RLAPI*/ RayCollision GetRayCollisionMesh(Ray ray, Mesh mesh, Matrix transform);                       // Get collision info between ray and mesh
/*RLAPI*/ RayCollision GetRayCollisionTriangle(Ray ray, Vector3 p1, Vector3 p2, Vector3 p3);            // Get collision info between ray and triangle
/*RLAPI*/ RayCollision GetRayCollisionQuad(Ray ray, Vector3 p1, Vector3 p2, Vector3 p3, Vector3 p4);    // Get collision info between ray and quad

RAYLIB_H;
} // RL_SUPPORT_MODULE_RMODELS

if ( RL_SUPPORT_MODULE_RAUDIO || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
$RAYLIB_H .= <<<'RAYLIB_H'

//------------------------------------------------------------------------------------
// Audio Loading and Playing Functions (Module: raudio)
//------------------------------------------------------------------------------------
typedef void (*AudioCallback)(void *bufferData, unsigned int frames);

// Audio device management functions
/*RLAPI*/ void InitAudioDevice(void);                                     // Initialize audio device and context
/*RLAPI*/ void CloseAudioDevice(void);                                    // Close the audio device and context
/*RLAPI*/ bool IsAudioDeviceReady(void);                                  // Check if audio device has been initialized successfully
/*RLAPI*/ void SetMasterVolume(float volume);                             // Set master volume (listener)

// Wave/Sound loading/unloading functions
/*RLAPI*/ Wave LoadWave(const char *fileName);                            // Load wave data from file
/*RLAPI*/ Wave LoadWaveFromMemory(const char *fileType, const unsigned char *fileData, int dataSize); // Load wave from memory buffer, fileType refers to extension: i.e. '.wav'
/*RLAPI*/ bool IsWaveReady(Wave wave);                                    // Checks if wave data is ready
/*RLAPI*/ Sound LoadSound(const char *fileName);                          // Load sound from file
/*RLAPI*/ Sound LoadSoundFromWave(Wave wave);                             // Load sound from wave data
/*RLAPI*/ bool IsSoundReady(Sound sound);                                 // Checks if a sound is ready
/*RLAPI*/ void UpdateSound(Sound sound, const void *data, int sampleCount); // Update sound buffer with new data
/*RLAPI*/ void UnloadWave(Wave wave);                                     // Unload wave data
/*RLAPI*/ void UnloadSound(Sound sound);                                  // Unload sound
/*RLAPI*/ bool ExportWave(Wave wave, const char *fileName);               // Export wave data to file, returns true on success
/*RLAPI*/ bool ExportWaveAsCode(Wave wave, const char *fileName);         // Export wave sample data to code (.h), returns true on success

// Wave/Sound management functions
/*RLAPI*/ void PlaySound(Sound sound);                                    // Play a sound
/*RLAPI*/ void StopSound(Sound sound);                                    // Stop playing a sound
/*RLAPI*/ void PauseSound(Sound sound);                                   // Pause a sound
/*RLAPI*/ void ResumeSound(Sound sound);                                  // Resume a paused sound
/*RLAPI*/ bool IsSoundPlaying(Sound sound);                               // Check if a sound is currently playing
/*RLAPI*/ void SetSoundVolume(Sound sound, float volume);                 // Set volume for a sound (1.0 is max level)
/*RLAPI*/ void SetSoundPitch(Sound sound, float pitch);                   // Set pitch for a sound (1.0 is base level)
/*RLAPI*/ void SetSoundPan(Sound sound, float pan);                       // Set pan for a sound (0.5 is center)
/*RLAPI*/ Wave WaveCopy(Wave wave);                                       // Copy a wave to a new wave
/*RLAPI*/ void WaveCrop(Wave *wave, int initSample, int finalSample);     // Crop a wave to defined samples range
/*RLAPI*/ void WaveFormat(Wave *wave, int sampleRate, int sampleSize, int channels); // Convert wave data to desired format
/*RLAPI*/ float *LoadWaveSamples(Wave wave);                              // Load samples data from wave as a 32bit float data array
/*RLAPI*/ void UnloadWaveSamples(float *samples);                         // Unload samples data loaded with LoadWaveSamples()

// Music management functions
/*RLAPI*/ Music LoadMusicStream(const char *fileName);                    // Load music stream from file
/*RLAPI*/ Music LoadMusicStreamFromMemory(const char *fileType, const unsigned char *data, int dataSize); // Load music stream from data
/*RLAPI*/ bool IsMusicReady(Music music);                                 // Checks if a music stream is ready
/*RLAPI*/ void UnloadMusicStream(Music music);                            // Unload music stream
/*RLAPI*/ void PlayMusicStream(Music music);                              // Start music playing
/*RLAPI*/ bool IsMusicStreamPlaying(Music music);                         // Check if music is playing
/*RLAPI*/ void UpdateMusicStream(Music music);                            // Updates buffers for music streaming
/*RLAPI*/ void StopMusicStream(Music music);                              // Stop music playing
/*RLAPI*/ void PauseMusicStream(Music music);                             // Pause music playing
/*RLAPI*/ void ResumeMusicStream(Music music);                            // Resume playing paused music
/*RLAPI*/ void SeekMusicStream(Music music, float position);              // Seek music to a position (in seconds)
/*RLAPI*/ void SetMusicVolume(Music music, float volume);                 // Set volume for music (1.0 is max level)
/*RLAPI*/ void SetMusicPitch(Music music, float pitch);                   // Set pitch for a music (1.0 is base level)
/*RLAPI*/ void SetMusicPan(Music music, float pan);                       // Set pan for a music (0.5 is center)
/*RLAPI*/ float GetMusicTimeLength(Music music);                          // Get music time length (in seconds)
/*RLAPI*/ float GetMusicTimePlayed(Music music);                          // Get current music time played (in seconds)

// AudioStream management functions
/*RLAPI*/ AudioStream LoadAudioStream(unsigned int sampleRate, unsigned int sampleSize, unsigned int channels); // Load audio stream (to stream raw audio pcm data)
/*RLAPI*/ bool IsAudioStreamReady(AudioStream stream);                    // Checks if an audio stream is ready
/*RLAPI*/ void UnloadAudioStream(AudioStream stream);                     // Unload audio stream and free memory
/*RLAPI*/ void UpdateAudioStream(AudioStream stream, const void *data, int frameCount); // Update audio stream buffers with data
/*RLAPI*/ bool IsAudioStreamProcessed(AudioStream stream);                // Check if any audio stream buffers requires refill
/*RLAPI*/ void PlayAudioStream(AudioStream stream);                       // Play audio stream
/*RLAPI*/ void PauseAudioStream(AudioStream stream);                      // Pause audio stream
/*RLAPI*/ void ResumeAudioStream(AudioStream stream);                     // Resume audio stream
/*RLAPI*/ bool IsAudioStreamPlaying(AudioStream stream);                  // Check if audio stream is playing
/*RLAPI*/ void StopAudioStream(AudioStream stream);                       // Stop audio stream
/*RLAPI*/ void SetAudioStreamVolume(AudioStream stream, float volume);    // Set volume for audio stream (1.0 is max level)
/*RLAPI*/ void SetAudioStreamPitch(AudioStream stream, float pitch);      // Set pitch for audio stream (1.0 is base level)
/*RLAPI*/ void SetAudioStreamPan(AudioStream stream, float pan);          // Set pan for audio stream (0.5 is centered)
/*RLAPI*/ void SetAudioStreamBufferSizeDefault(int size);                 // Default size for new audio streams
/*RLAPI*/ void SetAudioStreamCallback(AudioStream stream, AudioCallback callback);  // Audio thread callback to request new data

/*RLAPI*/ void AttachAudioStreamProcessor(AudioStream stream, AudioCallback processor); // Attach audio stream processor to stream
/*RLAPI*/ void DetachAudioStreamProcessor(AudioStream stream, AudioCallback processor); // Detach audio stream processor from stream

/*RLAPI*/ void AttachAudioMixedProcessor(AudioCallback processor); // Attach audio stream processor to the entire audio pipeline
/*RLAPI*/ void DetachAudioMixedProcessor(AudioCallback processor); // Detach audio stream processor from the entire audio pipeline

RAYLIB_H;
} // RL_SUPPORT_MODULE_RAUDIO


if ( RL_SUPPORT_MODULE_RMATH || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
$RAYLIB_H .= <<<'RAYLIB_H'

//----------------------------------------------------------------------------------
// Module Functions Definition - Utils math
//----------------------------------------------------------------------------------

/*RMAPI*/ float Clamp(float value, float min, float max); // Clamp float value
/*RMAPI*/ float Lerp(float start, float end, float amount); // Calculate linear interpolation between two floats
/*RMAPI*/ float Normalize(float value, float start, float end); // Normalize input value within input range
/*RMAPI*/ float Remap(float value, float inputStart, float inputEnd, float outputStart, float outputEnd); // Remap input value within input range to output range
/*RMAPI*/ float Wrap(float value, float min, float max); // Wrap input value from min to max
/*RMAPI*/ int FloatEquals(float x, float y); // Check whether two given floats are almost equal

//----------------------------------------------------------------------------------
// Module Functions Definition - Vector2 math
//----------------------------------------------------------------------------------

/*RMAPI*/ Vector2 Vector2Zero(void); // Vector with components value 0.0f
/*RMAPI*/ Vector2 Vector2One(void); // Vector with components value 1.0f
/*RMAPI*/ Vector2 Vector2Add(Vector2 v1, Vector2 v2); // Add two vectors (v1 + v2)
/*RMAPI*/ Vector2 Vector2AddValue(Vector2 v, float add); // Add vector and float value
/*RMAPI*/ Vector2 Vector2Subtract(Vector2 v1, Vector2 v2); // Subtract two vectors (v1 - v2)
/*RMAPI*/ Vector2 Vector2SubtractValue(Vector2 v, float sub); // Subtract vector by float value
/*RMAPI*/ float Vector2Length(Vector2 v); // Calculate vector length
/*RMAPI*/ float Vector2LengthSqr(Vector2 v); // Calculate vector square length
/*RMAPI*/ float Vector2DotProduct(Vector2 v1, Vector2 v2); // Calculate two vectors dot product
/*RMAPI*/ float Vector2Distance(Vector2 v1, Vector2 v2); // Calculate distance between two vectors
/*RMAPI*/ float Vector2DistanceSqr(Vector2 v1, Vector2 v2); // Calculate square distance between two vectors
/*RMAPI*/ float Vector2Angle(Vector2 v1, Vector2 v2); // Calculate angle between two vectors. NOTE: Angle is calculated from origin point (0, 0)
/*RMAPI*/ float Vector2LineAngle(Vector2 start, Vector2 end); // Calculate angle defined by a two vectors line. NOTE: Parameters need to be normalized. Current implementation should be aligned with glm::angle
/*RMAPI*/ Vector2 Vector2Scale(Vector2 v, float scale); // Scale vector (multiply by value)
/*RMAPI*/ Vector2 Vector2Multiply(Vector2 v1, Vector2 v2); // Multiply vector by vector
/*RMAPI*/ Vector2 Vector2Negate(Vector2 v); // Negate vector
/*RMAPI*/ Vector2 Vector2Divide(Vector2 v1, Vector2 v2); // Divide vector by vector
/*RMAPI*/ Vector2 Vector2Normalize(Vector2 v); // Normalize provided vector
/*RMAPI*/ Vector2 Vector2Transform(Vector2 v, Matrix mat); // Transforms a Vector2 by a given Matrix
/*RMAPI*/ Vector2 Vector2Lerp(Vector2 v1, Vector2 v2, float amount); // Calculate linear interpolation between two vectors
/*RMAPI*/ Vector2 Vector2Reflect(Vector2 v, Vector2 normal); // Calculate reflected vector to normal
/*RMAPI*/ Vector2 Vector2Rotate(Vector2 v, float angle); // Rotate vector by angle
/*RMAPI*/ Vector2 Vector2MoveTowards(Vector2 v, Vector2 target, float maxDistance); // Move Vector towards target
/*RMAPI*/ Vector2 Vector2Invert(Vector2 v); // Invert the given vector
/*RMAPI*/ Vector2 Vector2Clamp(Vector2 v, Vector2 min, Vector2 max); // Clamp the components of the vector between min and max values specified by the given vectors
/*RMAPI*/ Vector2 Vector2ClampValue(Vector2 v, float min, float max); // Clamp the magnitude of the vector between two min and max values
/*RMAPI*/ int Vector2Equals(Vector2 p, Vector2 q); // Check whether two given vectors are almost equal

//----------------------------------------------------------------------------------
// Module Functions Definition - Vector3 math
//----------------------------------------------------------------------------------

/*RMAPI*/ Vector3 Vector3Zero(void); // Vector with components value 0.0f
/*RMAPI*/ Vector3 Vector3One(void); // Vector with components value 1.0f
/*RMAPI*/ Vector3 Vector3Add(Vector3 v1, Vector3 v2); // Add two vectors
/*RMAPI*/ Vector3 Vector3AddValue(Vector3 v, float add); // Add vector and float value
/*RMAPI*/ Vector3 Vector3Subtract(Vector3 v1, Vector3 v2); // Subtract two vectors
/*RMAPI*/ Vector3 Vector3SubtractValue(Vector3 v, float sub); // Subtract vector by float value
/*RMAPI*/ Vector3 Vector3Scale(Vector3 v, float scalar); // Multiply vector by scalar
/*RMAPI*/ Vector3 Vector3Multiply(Vector3 v1, Vector3 v2); // Multiply vector by vector
/*RMAPI*/ Vector3 Vector3CrossProduct(Vector3 v1, Vector3 v2); // Calculate two vectors cross product
/*RMAPI*/ Vector3 Vector3Perpendicular(Vector3 v); // Calculate one vector perpendicular vector
/*RMAPI*/ float Vector3Length(const Vector3 v); // Calculate vector length
/*RMAPI*/ float Vector3LengthSqr(const Vector3 v); // Calculate vector square length
/*RMAPI*/ float Vector3DotProduct(Vector3 v1, Vector3 v2); // Calculate two vectors dot product
/*RMAPI*/ float Vector3Distance(Vector3 v1, Vector3 v2); // Calculate distance between two vectors
/*RMAPI*/ float Vector3DistanceSqr(Vector3 v1, Vector3 v2); // Calculate square distance between two vectors
/*RMAPI*/ float Vector3Angle(Vector3 v1, Vector3 v2); // Calculate angle between two vectors
/*RMAPI*/ Vector3 Vector3Negate(Vector3 v); // Negate provided vector (invert direction)
/*RMAPI*/ Vector3 Vector3Divide(Vector3 v1, Vector3 v2); // Divide vector by vector
/*RMAPI*/ Vector3 Vector3Normalize(Vector3 v); // Normalize provided vector
/*RMAPI*/ void Vector3OrthoNormalize(Vector3 *v1, Vector3 *v2); // Orthonormalize provided vectors. Makes vectors normalized and orthogonal to each other Gram-Schmidt function implementation
/*RMAPI*/ Vector3 Vector3Transform(Vector3 v, Matrix mat); // Transforms a Vector3 by a given Matrix
/*RMAPI*/ Vector3 Vector3RotateByQuaternion(Vector3 v, Quaternion q); // Transform a vector by quaternion rotation
/*RMAPI*/ Vector3 Vector3RotateByAxisAngle(Vector3 v, Vector3 axis, float angle); // Rotates a vector around an axis
/*RMAPI*/ Vector3 Vector3Lerp(Vector3 v1, Vector3 v2, float amount); // Calculate linear interpolation between two vectors
/*RMAPI*/ Vector3 Vector3Reflect(Vector3 v, Vector3 normal); // Calculate reflected vector to normal
/*RMAPI*/ Vector3 Vector3Min(Vector3 v1, Vector3 v2); // Get min value for each pair of components
/*RMAPI*/ Vector3 Vector3Max(Vector3 v1, Vector3 v2); // Get max value for each pair of components
/*RMAPI*/ Vector3 Vector3Barycenter(Vector3 p, Vector3 a, Vector3 b, Vector3 c); // Compute barycenter coordinates (u, v, w) for point p with respect to triangle (a, b, c). NOTE: Assumes P is on the plane of the triangle
/*RMAPI*/ Vector3 Vector3Unproject(Vector3 source, Matrix projection, Matrix view); // Projects a Vector3 from screen space into object space. NOTE: We are avoiding calling other raymath functions despite available
/*RMAPI*/ float3 Vector3ToFloatV(Vector3 v); // Get Vector3 as float array
/*RMAPI*/ Vector3 Vector3Invert(Vector3 v); // Invert the given vector
/*RMAPI*/ Vector3 Vector3Clamp(Vector3 v, Vector3 min, Vector3 max); // Clamp the components of the vector between min and max values specified by the given vectors
/*RMAPI*/ Vector3 Vector3ClampValue(Vector3 v, float min, float max); // Clamp the magnitude of the vector between two values
/*RMAPI*/ int Vector3Equals(Vector3 p, Vector3 q); // Check whether two given vectors are almost equal
/*RMAPI*/ Vector3 Vector3Refract(Vector3 v, Vector3 n, float r); // Compute the direction of a refracted ray where v specifies the normalized direction of the incoming ray, n specifies the normalized normal vector of the interface of two optical media, and r specifies the ratio of the refractive index of the medium from where the ray comes to the refractive index of the medium on the other side of the surface

//----------------------------------------------------------------------------------
// Module Functions Definition - Matrix math
//----------------------------------------------------------------------------------

/*RMAPI*/ float MatrixDeterminant(Matrix mat); // Compute matrix determinant
/*RMAPI*/ float MatrixTrace(Matrix mat); // Get the trace of the matrix (sum of the values along the diagonal)
/*RMAPI*/ Matrix MatrixTranspose(Matrix mat); // Transposes provided matrix
/*RMAPI*/ Matrix MatrixInvert(Matrix mat); // Invert provided matrix
/*RMAPI*/ Matrix MatrixIdentity(void); // Get identity matrix
/*RMAPI*/ Matrix MatrixAdd(Matrix left, Matrix right); // Add two matrices
/*RMAPI*/ Matrix MatrixSubtract(Matrix left, Matrix right); // Subtract two matrices (left - right)
/*RMAPI*/ Matrix MatrixMultiply(Matrix left, Matrix right); // Get two matrix multiplication. NOTE: When multiplying matrices... the order matters!
/*RMAPI*/ Matrix MatrixTranslate(float x, float y, float z); // Get translation matrix
/*RMAPI*/ Matrix MatrixRotate(Vector3 axis, float angle); // Create rotation matrix from axis and angle. NOTE: Angle should be provided in radians
/*RMAPI*/ Matrix MatrixRotateX(float angle); // Get x-rotation matrix. NOTE: Angle must be provided in radians
/*RMAPI*/ Matrix MatrixRotateY(float angle); // Get y-rotation matrix. NOTE: Angle must be provided in radians
/*RMAPI*/ Matrix MatrixRotateZ(float angle); // Get z-rotation matrix. NOTE: Angle must be provided in radians
/*RMAPI*/ Matrix MatrixRotateXYZ(Vector3 angle); // Get xyz-rotation matrix. NOTE: Angle must be provided in radians
/*RMAPI*/ Matrix MatrixRotateZYX(Vector3 angle); // Get zyx-rotation matrix. NOTE: Angle must be provided in radians
/*RMAPI*/ Matrix MatrixScale(float x, float y, float z); // Get scaling matrix
/*RMAPI*/ Matrix MatrixFrustum(double left, double right, double bottom, double top, double near, double far); // Get perspective projection matrix
/*RMAPI*/ Matrix MatrixPerspective(double fovy, double aspect, double near, double far); // Get perspective projection matrix. NOTE: Fovy angle must be provided in radians
/*RMAPI*/ Matrix MatrixOrtho(double left, double right, double bottom, double top, double near, double far); // Get orthographic projection matrix
/*RMAPI*/ Matrix MatrixLookAt(Vector3 eye, Vector3 target, Vector3 up); // Get camera look-at matrix (view matrix)
/*RMAPI*/ float16 MatrixToFloatV(Matrix mat); // Get float array of matrix data

//----------------------------------------------------------------------------------
// Module Functions Definition - Quaternion math
//----------------------------------------------------------------------------------

/*RMAPI*/ Quaternion QuaternionAdd(Quaternion q1, Quaternion q2); // Add two quaternions
/*RMAPI*/ Quaternion QuaternionAddValue(Quaternion q, float add); // Add quaternion and float value
/*RMAPI*/ Quaternion QuaternionSubtract(Quaternion q1, Quaternion q2); // Subtract two quaternions
/*RMAPI*/ Quaternion QuaternionSubtractValue(Quaternion q, float sub); // Subtract quaternion and float value
/*RMAPI*/ Quaternion QuaternionIdentity(void); // Get identity quaternion
/*RMAPI*/ float QuaternionLength(Quaternion q); // Computes the length of a quaternion
/*RMAPI*/ Quaternion QuaternionNormalize(Quaternion q); // Normalize provided quaternion
/*RMAPI*/ Quaternion QuaternionInvert(Quaternion q); // Invert provided quaternion
/*RMAPI*/ Quaternion QuaternionMultiply(Quaternion q1, Quaternion q2); // Calculate two quaternion multiplication
/*RMAPI*/ Quaternion QuaternionScale(Quaternion q, float mul); // Scale quaternion by float value
/*RMAPI*/ Quaternion QuaternionDivide(Quaternion q1, Quaternion q2); // Divide two quaternions
/*RMAPI*/ Quaternion QuaternionLerp(Quaternion q1, Quaternion q2, float amount); // Calculate linear interpolation between two quaternions
/*RMAPI*/ Quaternion QuaternionNlerp(Quaternion q1, Quaternion q2, float amount); // Calculate slerp-optimized interpolation between two quaternions
/*RMAPI*/ Quaternion QuaternionSlerp(Quaternion q1, Quaternion q2, float amount); // Calculates spherical linear interpolation between two quaternions
/*RMAPI*/ Quaternion QuaternionFromVector3ToVector3(Vector3 from, Vector3 to); // Calculate quaternion based on the rotation from one vector to another
/*RMAPI*/ Quaternion QuaternionFromMatrix(Matrix mat); // Get a quaternion for a given rotation matrix
/*RMAPI*/ Matrix QuaternionToMatrix(Quaternion q); // Get a matrix for a given quaternion
/*RMAPI*/ Quaternion QuaternionFromAxisAngle(Vector3 axis, float angle); // Get rotation quaternion for an angle and axis. NOTE: Angle must be provided in radians
/*RMAPI*/ void QuaternionToAxisAngle(Quaternion q, Vector3 *outAxis, float *outAngle); // Get the rotation angle and axis for a given quaternion
/*RMAPI*/ Quaternion QuaternionFromEuler(float pitch, float yaw, float roll); // Get the quaternion equivalent to Euler angles. NOTE: Rotation order is ZYX
/*RMAPI*/ Vector3 QuaternionToEuler(Quaternion q); // Get the Euler angles equivalent to quaternion (roll, pitch, yaw). NOTE: Angles are returned in a Vector3 struct in radians
/*RMAPI*/ Quaternion QuaternionTransform(Quaternion q, Matrix mat); // Transform a quaternion given a transformation matrix
/*RMAPI*/ int QuaternionEquals(Quaternion p, Quaternion q); // Check whether two given quaternions are almost equal

RAYLIB_H.PHP_EOL;
} // RL_SUPPORT_MODULE_RMATH


if ( RL_SUPPORT_MODULE_RLGL || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {

/**********************************************************************************************
*
*   rlgl v4.5 - A multi-OpenGL abstraction layer with an immediate-mode style API
*
*   An abstraction layer for multiple OpenGL versions (1.1, 2.1, 3.3 Core, 4.3 Core, ES 2.0)
*   that provides a pseudo-OpenGL 1.1 immediate-mode style API (rlVertex, rlTranslate, rlRotate...)
*
**********************************************************************************************/

define( 'RLGL_VERSION' ,  "4.5" );

switch( RL_USES_OPENGL_VERSION )
{
	case    1 : define( 'RL_GRAPHICS_API_OPENGL_11'  , true ); break ;
	case    2 : define( 'RL_GRAPHICS_API_OPENGL_21'  , true ); break ;
	case    3 : define( 'RL_GRAPHICS_API_OPENGL_33'  , true ); break ;
	case    4 : define( 'RL_GRAPHICS_API_OPENGL_43'  , true ); break ;
	case 0xE2 : define( 'RL_GRAPHICS_API_OPENGL_ES2' , true ); break ;
	default: exit( "Unsupported RL_USES_OPENGL_VERSION = ".RLGL_GRAPHICS_API_OPENGL_VERSION );
}

//----------------------------------------------------------------------------------
// Defines and Macros
//----------------------------------------------------------------------------------

// Default internal render batch elements limits
if ( ! defined( 'RLGL_DEFAULT_BATCH_BUFFER_ELEMENTS' ) )
{
	define( 'RLGL_DEFAULT_BATCH_BUFFER_ELEMENTS' , 8192 );
}

if ( ! defined( 'RLGL_DEFAULT_BATCH_BUFFER_ELEMENTS' ) )
{
	if ( defined( 'RLGL_GRAPHICS_API_OPENGL_11' ) || defined( 'RLGL_GRAPHICS_API_OPENGL_33' ) )
	{
		// This is the maximum amount of elements (quads) per batch
		// NOTE: Be careful with text, every letter maps to a quad
		define( 'RLGL_DEFAULT_BATCH_BUFFER_ELEMENTS' , 8192 );
	}
	else
	if ( defined( 'RLGL_GRAPHICS_API_OPENGL_ES2' ) )
	{
		// We reduce memory sizes for embedded systems (RPI and HTML5)
		// NOTE: On HTML5 (emscripten) this is allocated on heap,
		// by default it's only 16MB!...just take care...
		define( 'RLGL_DEFAULT_BATCH_BUFFER_ELEMENTS' , 2048 );
	}
}


// Texture parameters (equivalent to OpenGL defines)
define( 'RLGL_TEXTURE_WRAP_S'                      , 0x2802 );     // GL_TEXTURE_WRAP_S
define( 'RLGL_TEXTURE_WRAP_T'                      , 0x2803 );     // GL_TEXTURE_WRAP_T
define( 'RLGL_TEXTURE_MAG_FILTER'                  , 0x2800 );     // GL_TEXTURE_MAG_FILTER
define( 'RLGL_TEXTURE_MIN_FILTER'                  , 0x2801 );     // GL_TEXTURE_MIN_FILTER

define( 'RLGL_TEXTURE_FILTER_NEAREST'              , 0x2600 );     // GL_NEAREST
define( 'RLGL_TEXTURE_FILTER_LINEAR'               , 0x2601 );     // GL_LINEAR
define( 'RLGL_TEXTURE_FILTER_MIP_NEAREST'          , 0x2700 );     // GL_NEAREST_MIPMAP_NEAREST
define( 'RLGL_TEXTURE_FILTER_NEAREST_MIP_LINEAR'   , 0x2702 );     // GL_NEAREST_MIPMAP_LINEAR
define( 'RLGL_TEXTURE_FILTER_LINEAR_MIP_NEAREST'   , 0x2701 );     // GL_LINEAR_MIPMAP_NEAREST
define( 'RLGL_TEXTURE_FILTER_MIP_LINEAR'           , 0x2703 );     // GL_LINEAR_MIPMAP_LINEAR
define( 'RLGL_TEXTURE_FILTER_ANISOTROPIC'          , 0x3000 );     // Anisotropic filter (custom identifier)
define( 'RLGL_TEXTURE_MIPMAP_BIAS_RATIO'           , 0x4000 );     // Texture mipmap bias, percentage ratio (custom identifier)

define( 'RLGL_TEXTURE_WRAP_REPEAT'                 , 0x2901 );     // GL_REPEAT
define( 'RLGL_TEXTURE_WRAP_CLAMP'                  , 0x812F );     // GL_CLAMP_TO_EDGE
define( 'RLGL_TEXTURE_WRAP_MIRROR_REPEAT'          , 0x8370 );     // GL_MIRRORED_REPEAT
define( 'RLGL_TEXTURE_WRAP_MIRROR_CLAMP'           , 0x8742 );     // GL_MIRROR_CLAMP_EXT

// Matrix modes (equivalent to OpenGL)
define( 'RLGL_MODELVIEW'                           , 0x1700 );     // GL_MODELVIEW
define( 'RLGL_PROJECTION'                          , 0x1701 );     // GL_PROJECTION
define( 'RLGL_TEXTURE'                             , 0x1702 );     // GL_TEXTURE

// Primitive assembly draw modes
define( 'RLGL_LINES'                               , 0x0001 );     // GL_LINES
define( 'RLGL_TRIANGLES'                           , 0x0004 );     // GL_TRIANGLES
define( 'RLGL_QUADS'                               , 0x0007 );     // GL_QUADS

// GL equivalent data types
define( 'RLGL_UNSIGNED_BYTE'                       , 0x1401 );     // GL_UNSIGNED_BYTE
define( 'RLGL_FLOAT'                               , 0x1406 );     // GL_FLOAT

// GL buffer usage hint
define( 'RLGL_STREAM_DRAW'                         , 0x88E0 );     // GL_STREAM_DRAW
define( 'RLGL_STREAM_READ'                         , 0x88E1 );     // GL_STREAM_READ
define( 'RLGL_STREAM_COPY'                         , 0x88E2 );     // GL_STREAM_COPY
define( 'RLGL_STATIC_DRAW'                         , 0x88E4 );     // GL_STATIC_DRAW
define( 'RLGL_STATIC_READ'                         , 0x88E5 );     // GL_STATIC_READ
define( 'RLGL_STATIC_COPY'                         , 0x88E6 );     // GL_STATIC_COPY
define( 'RLGL_DYNAMIC_DRAW'                        , 0x88E8 );     // GL_DYNAMIC_DRAW
define( 'RLGL_DYNAMIC_READ'                        , 0x88E9 );     // GL_DYNAMIC_READ
define( 'RLGL_DYNAMIC_COPY'                        , 0x88EA );     // GL_DYNAMIC_COPY

// GL Shader type
define( 'RLGL_FRAGMENT_SHADER'                     , 0x8B30 );     // GL_FRAGMENT_SHADER
define( 'RLGL_VERTEX_SHADER'                       , 0x8B31 );     // GL_VERTEX_SHADER
define( 'RLGL_COMPUTE_SHADER'                      , 0x91B9 );     // GL_COMPUTE_SHADER

// GL blending factors
define( 'RLGL_ZERO'                                , 0      );     // GL_ZERO
define( 'RLGL_ONE'                                 , 1      );     // GL_ONE
define( 'RLGL_SRC_COLOR'                           , 0x0300 );     // GL_SRC_COLOR
define( 'RLGL_ONE_MINUS_SRC_COLOR'                 , 0x0301 );     // GL_ONE_MINUS_SRC_COLOR
define( 'RLGL_SRC_ALPHA'                           , 0x0302 );     // GL_SRC_ALPHA
define( 'RLGL_ONE_MINUS_SRC_ALPHA'                 , 0x0303 );     // GL_ONE_MINUS_SRC_ALPHA
define( 'RLGL_DST_ALPHA'                           , 0x0304 );     // GL_DST_ALPHA
define( 'RLGL_ONE_MINUS_DST_ALPHA'                 , 0x0305 );     // GL_ONE_MINUS_DST_ALPHA
define( 'RLGL_DST_COLOR'                           , 0x0306 );     // GL_DST_COLOR
define( 'RLGL_ONE_MINUS_DST_COLOR'                 , 0x0307 );     // GL_ONE_MINUS_DST_COLOR
define( 'RLGL_SRC_ALPHA_SATURATE'                  , 0x0308 );     // GL_SRC_ALPHA_SATURATE
define( 'RLGL_CONSTANT_COLOR'                      , 0x8001 );     // GL_CONSTANT_COLOR
define( 'RLGL_ONE_MINUS_CONSTANT_COLOR'            , 0x8002 );     // GL_ONE_MINUS_CONSTANT_COLOR
define( 'RLGL_CONSTANT_ALPHA'                      , 0x8003 );     // GL_CONSTANT_ALPHA
define( 'RLGL_ONE_MINUS_CONSTANT_ALPHA'            , 0x8004 );     // GL_ONE_MINUS_CONSTANT_ALPHA

// GL blending functions/equations
define( 'RLGL_FUNC_ADD'                            , 0x8006 );     // GL_FUNC_ADD
define( 'RLGL_MIN'                                 , 0x8007 );     // GL_MIN
define( 'RLGL_MAX'                                 , 0x8008 );     // GL_MAX
define( 'RLGL_FUNC_SUBTRACT'                       , 0x800A );     // GL_FUNC_SUBTRACT
define( 'RLGL_FUNC_REVERSE_SUBTRACT'               , 0x800B );     // GL_FUNC_REVERSE_SUBTRACT
define( 'RLGL_BLEND_EQUATION'                      , 0x8009 );     // GL_BLEND_EQUATION
define( 'RLGL_BLEND_EQUATION_RGB'                  , 0x8009 );     // GL_BLEND_EQUATION_RGB   // (Same as BLEND_EQUATION)
define( 'RLGL_BLEND_EQUATION_ALPHA'                , 0x883D );     // GL_BLEND_EQUATION_ALPHA
define( 'RLGL_BLEND_DST_RGB'                       , 0x80C8 );     // GL_BLEND_DST_RGB
define( 'RLGL_BLEND_SRC_RGB'                       , 0x80C9 );     // GL_BLEND_SRC_RGB
define( 'RLGL_BLEND_DST_ALPHA'                     , 0x80CA );     // GL_BLEND_DST_ALPHA
define( 'RLGL_BLEND_SRC_ALPHA'                     , 0x80CB );     // GL_BLEND_SRC_ALPHA
define( 'RLGL_BLEND_COLOR'                         , 0x8005 );     // GL_BLEND_COLOR


//----------------------------------------------------------------------------------
// Types and Structures Definition
//----------------------------------------------------------------------------------

// Dynamic vertex buffers (position + texcoords + colors + indices arrays)

$RAYLIB_H .= <<<'RAYLIB_H'

typedef struct rlVertexBuffer {
    int elementCount;           // Number of elements in the buffer (QUADS)

    float *vertices;            // Vertex position (XYZ - 3 components per vertex) (shader-location = 0)
    float *texcoords;           // Vertex texture coordinates (UV - 2 components per vertex) (shader-location = 1)
    unsigned char *colors;      // Vertex colors (RGBA - 4 components per vertex) (shader-location = 3)

RAYLIB_H;

if ( defined( 'RLGL_GRAPHICS_API_OPENGL_11' ) || defined( 'RLGL_GRAPHICS_API_OPENGL_33' ) )
{
$RAYLIB_H .= <<<'RAYLIB_H'

    unsigned int *indices;      // Vertex indices (in case vertex data comes indexed) (6 indices per quad)

RAYLIB_H;
}

if ( defined( 'RLGL_GRAPHICS_API_OPENGL_ES2' ) )
{
$RAYLIB_H .= <<<'RAYLIB_H'

    unsigned short *indices;    // Vertex indices (in case vertex data comes indexed) (6 indices per quad)

RAYLIB_H;
}

$RAYLIB_H .= <<<'RAYLIB_H'

    unsigned int vaoId;         // OpenGL Vertex Array Object id
    unsigned int vboId[4];      // OpenGL Vertex Buffer Objects id (4 types of vertex data)
} rlVertexBuffer;

RAYLIB_H;

$RAYLIB_H .= <<<'RAYLIB_H'

// Draw call type
// NOTE: Only texture changes register a new draw, other state-change-related elements are not
// used at this moment (vaoId, shaderId, matrices), raylib just forces a batch draw call if any
// of those state-change happens (this is done in core module)
typedef struct rlDrawCall {
    int mode;                   // Drawing mode: LINES, TRIANGLES, QUADS
    int vertexCount;            // Number of vertex of the draw
    int vertexAlignment;        // Number of vertex required for index alignment (LINES, TRIANGLES)
    //unsigned int vaoId;       // Vertex array id to be used on the draw -> Using RLGL.currentBatch->vertexBuffer.vaoId
    //unsigned int shaderId;    // Shader id to be used on the draw -> Using RLGL.currentShaderId
    unsigned int textureId;     // Texture id to be used on the draw -> Use to create new draw call if changes

    //Matrix projection;        // Projection matrix for this draw -> Using RLGL.projection by default
    //Matrix modelview;         // Modelview matrix for this draw -> Using RLGL.modelview by default
} rlDrawCall;

// rlRenderBatch type
typedef struct rlRenderBatch {
    int bufferCount;            // Number of vertex buffers (multi-buffering support)
    int currentBuffer;          // Current buffer tracking in case of multi-buffering
    rlVertexBuffer *vertexBuffer; // Dynamic buffer(s) for vertex data

    rlDrawCall *draws;          // Draw calls array, depends on textureId
    int drawCounter;            // Draw calls counter
    float currentDepth;         // Current depth value for next draw
} rlRenderBatch;

RAYLIB_H;

// OpenGL version
//typedef enum {
define( 'RLGL_OPENGL_11'    , 1 );  // OpenGL 1.1
define( 'RLGL_OPENGL_21'    , 2 );  // OpenGL 2.1 (GLSL 120)
define( 'RLGL_OPENGL_33'    , 3 );  // OpenGL 3.3 (GLSL 330)
define( 'RLGL_OPENGL_43'    , 4 );  // OpenGL 4.3 (using GLSL 330)
define( 'RLGL_OPENGL_ES_20' , 5 );  // OpenGL ES 2.0 (GLSL 100)
//} rlGlVersion;

// Texture pixel formats
// NOTE: Support depends on OpenGL version
//typedef enum {
define( 'RLGL_PIXELFORMAT_UNCOMPRESSED_GRAYSCALE'    ,  1 );  // 8 bit per pixel (no alpha)
define( 'RLGL_PIXELFORMAT_UNCOMPRESSED_GRAY_ALPHA'   ,  2 );  // 8*2 bpp (2 channels)
define( 'RLGL_PIXELFORMAT_UNCOMPRESSED_R5G6B5'       ,  3 );  // 16 bpp
define( 'RLGL_PIXELFORMAT_UNCOMPRESSED_R8G8B8'       ,  4 );  // 24 bpp
define( 'RLGL_PIXELFORMAT_UNCOMPRESSED_R5G5B5A1'     ,  5 );  // 16 bpp (1 bit alpha)
define( 'RLGL_PIXELFORMAT_UNCOMPRESSED_R4G4B4A4'     ,  6 );  // 16 bpp (4 bit alpha)
define( 'RLGL_PIXELFORMAT_UNCOMPRESSED_R8G8B8A8'     ,  7 );  // 32 bpp
define( 'RLGL_PIXELFORMAT_UNCOMPRESSED_R32'          ,  8 );  // 32 bpp (1 channel - float)
define( 'RLGL_PIXELFORMAT_UNCOMPRESSED_R32G32B32'    ,  9 );  // 32*3 bpp (3 channels - float)
define( 'RLGL_PIXELFORMAT_UNCOMPRESSED_R32G32B32A32' , 10 );  // 32*4 bpp (4 channels - float)
define( 'RLGL_PIXELFORMAT_COMPRESSED_DXT1_RGB'       , 11 );  // 4 bpp (no alpha)
define( 'RLGL_PIXELFORMAT_COMPRESSED_DXT1_RGBA'      , 12 );  // 4 bpp (1 bit alpha)
define( 'RLGL_PIXELFORMAT_COMPRESSED_DXT3_RGBA'      , 13 );  // 8 bpp
define( 'RLGL_PIXELFORMAT_COMPRESSED_DXT5_RGBA'      , 14 );  // 8 bpp
define( 'RLGL_PIXELFORMAT_COMPRESSED_ETC1_RGB'       , 15 );  // 4 bpp
define( 'RLGL_PIXELFORMAT_COMPRESSED_ETC2_RGB'       , 16 );  // 4 bpp
define( 'RLGL_PIXELFORMAT_COMPRESSED_ETC2_EAC_RGBA'  , 17 );  // 8 bpp
define( 'RLGL_PIXELFORMAT_COMPRESSED_PVRT_RGB'       , 18 );  // 4 bpp
define( 'RLGL_PIXELFORMAT_COMPRESSED_PVRT_RGBA'      , 19 );  // 4 bpp
define( 'RLGL_PIXELFORMAT_COMPRESSED_ASTC_4x4_RGBA'  , 20 );  // 8 bpp
define( 'RLGL_PIXELFORMAT_COMPRESSED_ASTC_8x8_RGBA'  , 21 );  // 2 bpp
//} rlPixelFormat;

// Texture parameters: filter mode
// NOTE 1: Filtering considers mipmaps if available in the texture
// NOTE 2: Filter is accordingly set for minification and magnification
//typedef enum {
define( 'RLGL_TEXTURE_FILTER_POINT'          , 0 ); // No filter, just pixel approximation
define( 'RLGL_TEXTURE_FILTER_BILINEAR'       , 1 ); // Linear filtering
define( 'RLGL_TEXTURE_FILTER_TRILINEAR'      , 2 ); // Trilinear filtering (linear with mipmaps)
define( 'RLGL_TEXTURE_FILTER_ANISOTROPIC_4X' , 3 ); // Anisotropic filtering 4x
define( 'RLGL_TEXTURE_FILTER_ANISOTROPIC_8X' , 4 ); // Anisotropic filtering 8x
define( 'RLGL_TEXTURE_FILTER_ANISOTROPIC_16X', 5 ); // Anisotropic filtering 16x
//} rlTextureFilter;

// Color blending modes (pre-defined)
//typedef enum {
define( 'RLGL_BLEND_ALPHA'             , 0 );       // Blend textures considering alpha (default)
define( 'RLGL_BLEND_ADDITIVE'          , 1 );       // Blend textures adding colors
define( 'RLGL_BLEND_MULTIPLIED'        , 2 );       // Blend textures multiplying colors
define( 'RLGL_BLEND_ADD_COLORS'        , 3 );       // Blend textures adding colors (alternative)
define( 'RLGL_BLEND_SUBTRACT_COLORS'   , 4 );       // Blend textures subtracting colors (alternative)
define( 'RLGL_BLEND_ALPHA_PREMULTIPLY' , 5 );       // Blend premultiplied textures considering alpha
define( 'RLGL_BLEND_CUSTOM'            , 6 );       // Blend textures using custom src/dst factors (use rlSetBlendFactors())
define( 'RLGL_BLEND_CUSTOM_SEPARATE'   , 7 );       // Blend textures using custom src/dst factors (use rlSetBlendFactorsSeparate())
//} rlBlendMode;

// Shader location point type
//typedef enum {
define( 'RLGL_SHADER_LOC_VERTEX_POSITION'   ,  0 ); // Shader location: vertex attribute: position
define( 'RLGL_SHADER_LOC_VERTEX_TEXCOORD01' ,  1 ); // Shader location: vertex attribute: texcoord01
define( 'RLGL_SHADER_LOC_VERTEX_TEXCOORD02' ,  2 ); // Shader location: vertex attribute: texcoord02
define( 'RLGL_SHADER_LOC_VERTEX_NORMAL'     ,  3 ); // Shader location: vertex attribute: normal
define( 'RLGL_SHADER_LOC_VERTEX_TANGENT'    ,  4 ); // Shader location: vertex attribute: tangent
define( 'RLGL_SHADER_LOC_VERTEX_COLOR'      ,  5 ); // Shader location: vertex attribute: color
define( 'RLGL_SHADER_LOC_MATRIX_MVP'        ,  6 ); // Shader location: matrix uniform: model-view-projection
define( 'RLGL_SHADER_LOC_MATRIX_VIEW'       ,  7 ); // Shader location: matrix uniform: view (camera transform)
define( 'RLGL_SHADER_LOC_MATRIX_PROJECTION' ,  8 ); // Shader location: matrix uniform: projection
define( 'RLGL_SHADER_LOC_MATRIX_MODEL'      ,  9 ); // Shader location: matrix uniform: model (transform)
define( 'RLGL_SHADER_LOC_MATRIX_NORMAL'     , 10 ); // Shader location: matrix uniform: normal
define( 'RLGL_SHADER_LOC_VECTOR_VIEW'       , 11 ); // Shader location: vector uniform: view
define( 'RLGL_SHADER_LOC_COLOR_DIFFUSE'     , 12 ); // Shader location: vector uniform: diffuse color
define( 'RLGL_SHADER_LOC_COLOR_SPECULAR'    , 13 ); // Shader location: vector uniform: specular color
define( 'RLGL_SHADER_LOC_COLOR_AMBIENT'     , 14 ); // Shader location: vector uniform: ambient color
define( 'RLGL_SHADER_LOC_MAP_ALBEDO'        , 15 ); // Shader location: sampler2d texture: albedo (same as: RL_SHADER_LOC_MAP_DIFFUSE)
define( 'RLGL_SHADER_LOC_MAP_METALNESS'     , 16 ); // Shader location: sampler2d texture: metalness (same as: RL_SHADER_LOC_MAP_SPECULAR)
define( 'RLGL_SHADER_LOC_MAP_NORMAL'        , 17 ); // Shader location: sampler2d texture: normal
define( 'RLGL_SHADER_LOC_MAP_ROUGHNESS'     , 18 ); // Shader location: sampler2d texture: roughness
define( 'RLGL_SHADER_LOC_MAP_OCCLUSION'     , 19 ); // Shader location: sampler2d texture: occlusion
define( 'RLGL_SHADER_LOC_MAP_EMISSION'      , 20 ); // Shader location: sampler2d texture: emission
define( 'RLGL_SHADER_LOC_MAP_HEIGHT'        , 21 ); // Shader location: sampler2d texture: height
define( 'RLGL_SHADER_LOC_MAP_CUBEMAP'       , 22 ); // Shader location: samplerCube texture: cubemap
define( 'RLGL_SHADER_LOC_MAP_IRRADIANCE'    , 23 ); // Shader location: samplerCube texture: irradiance
define( 'RLGL_SHADER_LOC_MAP_PREFILTER'     , 24 ); // Shader location: samplerCube texture: prefilter
define( 'RLGL_SHADER_LOC_MAP_BRDF'          , 25 ); // Shader location: sampler2d texture: brdf
//} rlShaderLocationIndex;

define( 'RLGL_SHADER_LOC_MAP_DIFFUSE'   ,    RLGL_SHADER_LOC_MAP_ALBEDO );
define( 'RLGL_SHADER_LOC_MAP_SPECULAR'  ,    RLGL_SHADER_LOC_MAP_METALNESS );

// Shader uniform data type
//typedef enum {
define( 'RLGL_SHADER_UNIFORM_FLOAT'    , 0 );      // Shader uniform type: float
define( 'RLGL_SHADER_UNIFORM_VEC2'     , 1 );      // Shader uniform type: vec2 (2 float)
define( 'RLGL_SHADER_UNIFORM_VEC3'     , 2 );      // Shader uniform type: vec3 (3 float)
define( 'RLGL_SHADER_UNIFORM_VEC4'     , 3 );      // Shader uniform type: vec4 (4 float)
define( 'RLGL_SHADER_UNIFORM_INT'      , 4 );      // Shader uniform type: int
define( 'RLGL_SHADER_UNIFORM_IVEC2'    , 5 );      // Shader uniform type: ivec2 (2 int)
define( 'RLGL_SHADER_UNIFORM_IVEC3'    , 6 );      // Shader uniform type: ivec3 (3 int)
define( 'RLGL_SHADER_UNIFORM_IVEC4'    , 7 );      // Shader uniform type: ivec4 (4 int)
define( 'RLGL_SHADER_UNIFORM_SAMPLER2D', 8 );      // Shader uniform type: sampler2d
//} rlShaderUniformDataType;

// Shader attribute data types
//typedef enum {
define( 'RLGL_SHADER_ATTRIB_FLOAT' , 0 );      // Shader attribute type: float
define( 'RLGL_SHADER_ATTRIB_VEC2'  , 1 );      // Shader attribute type: vec2 (2 float)
define( 'RLGL_SHADER_ATTRIB_VEC3'  , 2 );      // Shader attribute type: vec3 (3 float)
define( 'RLGL_SHADER_ATTRIB_VEC4'  , 3 );      // Shader attribute type: vec4 (4 float)
//} rlShaderAttributeDataType;

// Framebuffer attachment type
// NOTE: By default up to 8 color channels defined, but it can be more
//typedef enum {
define( 'RLGL_ATTACHMENT_COLOR_CHANNEL0' , 0 );    // Framebuffer attachment type: color 0
define( 'RLGL_ATTACHMENT_COLOR_CHANNEL1' , 1 );    // Framebuffer attachment type: color 1
define( 'RLGL_ATTACHMENT_COLOR_CHANNEL2' , 2 );    // Framebuffer attachment type: color 2
define( 'RLGL_ATTACHMENT_COLOR_CHANNEL3' , 3 );    // Framebuffer attachment type: color 3
define( 'RLGL_ATTACHMENT_COLOR_CHANNEL4' , 4 );    // Framebuffer attachment type: color 4
define( 'RLGL_ATTACHMENT_COLOR_CHANNEL5' , 5 );    // Framebuffer attachment type: color 5
define( 'RLGL_ATTACHMENT_COLOR_CHANNEL6' , 6 );    // Framebuffer attachment type: color 6
define( 'RLGL_ATTACHMENT_COLOR_CHANNEL7' , 7 );    // Framebuffer attachment type: color 7
define( 'RLGL_ATTACHMENT_DEPTH'          , 100 );  // Framebuffer attachment type: depth
define( 'RLGL_ATTACHMENT_STENCIL'        , 200 );  // Framebuffer attachment type: stencil
//} rlFramebufferAttachType;

// Framebuffer texture attachment type
//typedef enum {
define( 'RLGL_ATTACHMENT_CUBEMAP_POSITIVE_X' , 0 );   // Framebuffer texture attachment type: cubemap, +X side
define( 'RLGL_ATTACHMENT_CUBEMAP_NEGATIVE_X' , 1 );   // Framebuffer texture attachment type: cubemap, -X side
define( 'RLGL_ATTACHMENT_CUBEMAP_POSITIVE_Y' , 2 );   // Framebuffer texture attachment type: cubemap, +Y side
define( 'RLGL_ATTACHMENT_CUBEMAP_NEGATIVE_Y' , 3 );   // Framebuffer texture attachment type: cubemap, -Y side
define( 'RLGL_ATTACHMENT_CUBEMAP_POSITIVE_Z' , 4 );   // Framebuffer texture attachment type: cubemap, +Z side
define( 'RLGL_ATTACHMENT_CUBEMAP_NEGATIVE_Z' , 5 );   // Framebuffer texture attachment type: cubemap, -Z side
define( 'RLGL_ATTACHMENT_TEXTURE2D'          , 100 ); // Framebuffer texture attachment type: texture2d
define( 'RLGL_ATTACHMENT_RENDERBUFFER'       , 200 ); // Framebuffer texture attachment type: renderbuffer
//} rlFramebufferAttachTextureType;

// Face culling mode
//typedef enum {
define( 'RLGL_CULL_FACE_FRONT', 0 );
define( 'RLGL_CULL_FACE_BACK' , 1 );
//} rlCullMode;

//------------------------------------------------------------------------------------
// Functions Declaration - Matrix operations
//------------------------------------------------------------------------------------

$RAYLIB_H .=<<<'RAYLIB_H'

/*RLAPI*/ void rlMatrixMode(int mode);                    // Choose the current matrix to be transformed
/*RLAPI*/ void rlPushMatrix(void);                        // Push the current matrix to stack
/*RLAPI*/ void rlPopMatrix(void);                         // Pop latest inserted matrix from stack
/*RLAPI*/ void rlLoadIdentity(void);                      // Reset current matrix to identity matrix
/*RLAPI*/ void rlTranslatef(float x, float y, float z);   // Multiply the current matrix by a translation matrix
/*RLAPI*/ void rlRotatef(float angle, float x, float y, float z);  // Multiply the current matrix by a rotation matrix
/*RLAPI*/ void rlScalef(float x, float y, float z);       // Multiply the current matrix by a scaling matrix
/*RLAPI*/ void rlMultMatrixf(const float *matf);                // Multiply the current matrix by another matrix
/*RLAPI*/ void rlFrustum(double left, double right, double bottom, double top, double znear, double zfar);
/*RLAPI*/ void rlOrtho(double left, double right, double bottom, double top, double znear, double zfar);
/*RLAPI*/ void rlViewport(int x, int y, int width, int height); // Set the viewport area

//------------------------------------------------------------------------------------
// Functions Declaration - Vertex level operations
//------------------------------------------------------------------------------------
/*RLAPI*/ void rlBegin(int mode);                         // Initialize drawing mode (how to organize vertex)
/*RLAPI*/ void rlEnd(void);                               // Finish vertex providing
/*RLAPI*/ void rlVertex2i(int x, int y);                  // Define one vertex (position) - 2 int
/*RLAPI*/ void rlVertex2f(float x, float y);              // Define one vertex (position) - 2 float
/*RLAPI*/ void rlVertex3f(float x, float y, float z);     // Define one vertex (position) - 3 float
/*RLAPI*/ void rlTexCoord2f(float x, float y);            // Define one vertex (texture coordinate) - 2 float
/*RLAPI*/ void rlNormal3f(float x, float y, float z);     // Define one vertex (normal) - 3 float
/*RLAPI*/ void rlColor4ub(unsigned char r, unsigned char g, unsigned char b, unsigned char a);  // Define one vertex (color) - 4 byte
/*RLAPI*/ void rlColor3f(float x, float y, float z);          // Define one vertex (color) - 3 float
/*RLAPI*/ void rlColor4f(float x, float y, float z, float w); // Define one vertex (color) - 4 float

//------------------------------------------------------------------------------------
// Functions Declaration - OpenGL style functions (common to 1.1, 3.3+, ES2)
// NOTE: This functions are used to completely abstract raylib code from OpenGL layer,
// some of them are direct wrappers over OpenGL calls, some others are custom
//------------------------------------------------------------------------------------

// Vertex buffers state
/*RLAPI*/ bool rlEnableVertexArray(unsigned int vaoId);     // Enable vertex array (VAO, if supported)
/*RLAPI*/ void rlDisableVertexArray(void);                  // Disable vertex array (VAO, if supported)
/*RLAPI*/ void rlEnableVertexBuffer(unsigned int id);       // Enable vertex buffer (VBO)
/*RLAPI*/ void rlDisableVertexBuffer(void);                 // Disable vertex buffer (VBO)
/*RLAPI*/ void rlEnableVertexBufferElement(unsigned int id);// Enable vertex buffer element (VBO element)
/*RLAPI*/ void rlDisableVertexBufferElement(void);          // Disable vertex buffer element (VBO element)
/*RLAPI*/ void rlEnableVertexAttribute(unsigned int index); // Enable vertex attribute index
/*RLAPI*/ void rlDisableVertexAttribute(unsigned int index);// Disable vertex attribute index

RAYLIB_H;

if ( defined( 'RL_GRAPHICS_API_OPENGL_11' ) )
{
$RAYLIB_H .= <<<'RAYLIB_H'

/*RLAPI*/ void rlEnableStatePointer(int vertexAttribType, void *buffer);    // Enable attribute state pointer
/*RLAPI*/ void rlDisableStatePointer(int vertexAttribType);                 // Disable attribute state pointer

RAYLIB_H;
}

$RAYLIB_H .= <<<'RAYLIB_H'

// Textures state
/*RLAPI*/ void rlActiveTextureSlot(int slot);               // Select and active a texture slot
/*RLAPI*/ void rlEnableTexture(unsigned int id);            // Enable texture
/*RLAPI*/ void rlDisableTexture(void);                      // Disable texture
/*RLAPI*/ void rlEnableTextureCubemap(unsigned int id);     // Enable texture cubemap
/*RLAPI*/ void rlDisableTextureCubemap(void);               // Disable texture cubemap
/*RLAPI*/ void rlTextureParameters(unsigned int id, int param, int value); // Set texture parameters (filter, wrap)
/*RLAPI*/ void rlCubemapParameters(unsigned int id, int param, int value); // Set cubemap parameters (filter, wrap)

// Shader state
/*RLAPI*/ void rlEnableShader(unsigned int id);             // Enable shader program
/*RLAPI*/ void rlDisableShader(void);                       // Disable shader program

// Framebuffer state
/*RLAPI*/ void rlEnableFramebuffer(unsigned int id);        // Enable render texture (fbo)
/*RLAPI*/ void rlDisableFramebuffer(void);                  // Disable render texture (fbo), return to default framebuffer
/*RLAPI*/ void rlActiveDrawBuffers(int count);              // Activate multiple draw color buffers

// General render state
/*RLAPI*/ void rlEnableColorBlend(void);                     // Enable color blending
/*RLAPI*/ void rlDisableColorBlend(void);                   // Disable color blending
/*RLAPI*/ void rlEnableDepthTest(void);                     // Enable depth test
/*RLAPI*/ void rlDisableDepthTest(void);                    // Disable depth test
/*RLAPI*/ void rlEnableDepthMask(void);                     // Enable depth write
/*RLAPI*/ void rlDisableDepthMask(void);                    // Disable depth write
/*RLAPI*/ void rlEnableBackfaceCulling(void);               // Enable backface culling
/*RLAPI*/ void rlDisableBackfaceCulling(void);              // Disable backface culling
/*RLAPI*/ void rlSetCullFace(int mode);                     // Set face culling mode
/*RLAPI*/ void rlEnableScissorTest(void);                   // Enable scissor test
/*RLAPI*/ void rlDisableScissorTest(void);                  // Disable scissor test
/*RLAPI*/ void rlScissor(int x, int y, int width, int height); // Scissor test
/*RLAPI*/ void rlEnableWireMode(void);                      // Enable wire mode
/*RLAPI*/ void rlDisableWireMode(void);                     // Disable wire mode
/*RLAPI*/ void rlSetLineWidth(float width);                 // Set the line drawing width
/*RLAPI*/ float rlGetLineWidth(void);                       // Get the line drawing width
/*RLAPI*/ void rlEnableSmoothLines(void);                   // Enable line aliasing
/*RLAPI*/ void rlDisableSmoothLines(void);                  // Disable line aliasing
/*RLAPI*/ void rlEnableStereoRender(void);                  // Enable stereo rendering
/*RLAPI*/ void rlDisableStereoRender(void);                 // Disable stereo rendering
/*RLAPI*/ bool rlIsStereoRenderEnabled(void);               // Check if stereo render is enabled

/*RLAPI*/ void rlClearColor(unsigned char r, unsigned char g, unsigned char b, unsigned char a); // Clear color buffer with color
/*RLAPI*/ void rlClearScreenBuffers(void);                  // Clear used screen buffers (color and depth)
/*RLAPI*/ void rlCheckErrors(void);                         // Check and log OpenGL error codes
/*RLAPI*/ void rlSetBlendMode(int mode);                    // Set blending mode
/*RLAPI*/ void rlSetBlendFactors(int glSrcFactor, int glDstFactor, int glEquation); // Set blending mode factor and equation (using OpenGL factors)
/*RLAPI*/ void rlSetBlendFactorsSeparate(int glSrcRGB, int glDstRGB, int glSrcAlpha, int glDstAlpha, int glEqRGB, int glEqAlpha); // Set blending mode factors and equations separately (using OpenGL factors)

//------------------------------------------------------------------------------------
// Functions Declaration - rlgl functionality
//------------------------------------------------------------------------------------
// rlgl initialization functions
/*RLAPI*/ void rlglInit(int width, int height);             // Initialize rlgl (buffers, shaders, textures, states)
/*RLAPI*/ void rlglClose(void);                             // De-initialize rlgl (buffers, shaders, textures)
/*RLAPI*/ void rlLoadExtensions(void *loader);              // Load OpenGL extensions (loader function required)
/*RLAPI*/ int rlGetVersion(void);                           // Get current OpenGL version
/*RLAPI*/ void rlSetFramebufferWidth(int width);            // Set current framebuffer width
/*RLAPI*/ int rlGetFramebufferWidth(void);                  // Get default framebuffer width
/*RLAPI*/ void rlSetFramebufferHeight(int height);          // Set current framebuffer height
/*RLAPI*/ int rlGetFramebufferHeight(void);                 // Get default framebuffer height

/*RLAPI*/ unsigned int rlGetTextureIdDefault(void);         // Get default texture id
/*RLAPI*/ unsigned int rlGetShaderIdDefault(void);          // Get default shader id
/*RLAPI*/ int *rlGetShaderLocsDefault(void);                // Get default shader locations

// Render batch management
// NOTE: rlgl provides a default render batch to behave like OpenGL 1.1 immediate mode
// but this render batch API is exposed in case of custom batches are required
/*RLAPI*/ rlRenderBatch rlLoadRenderBatch(int numBuffers, int bufferElements);  // Load a render batch system
/*RLAPI*/ void rlUnloadRenderBatch(rlRenderBatch batch);                        // Unload render batch system
/*RLAPI*/ void rlDrawRenderBatch(rlRenderBatch *batch);                         // Draw render batch data (Update->Draw->Reset)
/*RLAPI*/ void rlSetRenderBatchActive(rlRenderBatch *batch);                    // Set the active render batch for rlgl (NULL for default internal)
/*RLAPI*/ void rlDrawRenderBatchActive(void);                                   // Update and draw internal render batch
/*RLAPI*/ bool rlCheckRenderBatchLimit(int vCount);                             // Check internal buffer overflow for a given number of vertex

/*RLAPI*/ void rlSetTexture(unsigned int id);               // Set current texture for render batch and check buffers limits

//------------------------------------------------------------------------------------------------------------------------

// Vertex buffers management
/*RLAPI*/ unsigned int rlLoadVertexArray(void);                               // Load vertex array (vao) if supported
/*RLAPI*/ unsigned int rlLoadVertexBuffer(const void *buffer, int size, bool dynamic);            // Load a vertex buffer attribute
/*RLAPI*/ unsigned int rlLoadVertexBufferElement(const void *buffer, int size, bool dynamic);     // Load a new attributes element buffer
/*RLAPI*/ void rlUpdateVertexBuffer(unsigned int bufferId, const void *data, int dataSize, int offset);     // Update GPU buffer with new data
/*RLAPI*/ void rlUpdateVertexBufferElements(unsigned int id, const void *data, int dataSize, int offset);   // Update vertex buffer elements with new data
/*RLAPI*/ void rlUnloadVertexArray(unsigned int vaoId);
/*RLAPI*/ void rlUnloadVertexBuffer(unsigned int vboId);
/*RLAPI*/ void rlSetVertexAttribute(unsigned int index, int compSize, int type, bool normalized, int stride, const void *pointer);
/*RLAPI*/ void rlSetVertexAttributeDivisor(unsigned int index, int divisor);
/*RLAPI*/ void rlSetVertexAttributeDefault(int locIndex, const void *value, int attribType, int count); // Set vertex attribute default value
/*RLAPI*/ void rlDrawVertexArray(int offset, int count);
/*RLAPI*/ void rlDrawVertexArrayElements(int offset, int count, const void *buffer);
/*RLAPI*/ void rlDrawVertexArrayInstanced(int offset, int count, int instances);
/*RLAPI*/ void rlDrawVertexArrayElementsInstanced(int offset, int count, const void *buffer, int instances);

// Textures management
/*RLAPI*/ unsigned int rlLoadTexture(const void *data, int width, int height, int format, int mipmapCount); // Load texture in GPU
/*RLAPI*/ unsigned int rlLoadTextureDepth(int width, int height, bool useRenderBuffer);               // Load depth texture/renderbuffer (to be attached to fbo)
/*RLAPI*/ unsigned int rlLoadTextureCubemap(const void *data, int size, int format);                        // Load texture cubemap
/*RLAPI*/ void rlUpdateTexture(unsigned int id, int offsetX, int offsetY, int width, int height, int format, const void *data);  // Update GPU texture with new data
/*RLAPI*/ void rlGetGlTextureFormats(int format, unsigned int *glInternalFormat, unsigned int *glFormat, unsigned int *glType);  // Get OpenGL internal formats
/*RLAPI*/ const char *rlGetPixelFormatName(unsigned int format);              // Get name string for pixel format
/*RLAPI*/ void rlUnloadTexture(unsigned int id);                              // Unload texture from GPU memory
/*RLAPI*/ void rlGenTextureMipmaps(unsigned int id, int width, int height, int format, int *mipmaps); // Generate mipmap data for selected texture
/*RLAPI*/ void *rlReadTexturePixels(unsigned int id, int width, int height, int format);              // Read texture pixel data
/*RLAPI*/ unsigned char *rlReadScreenPixels(int width, int height);           // Read screen pixel data (color buffer)

// Framebuffer management (fbo)
/*RLAPI*/ unsigned int rlLoadFramebuffer(int width, int height);              // Load an empty framebuffer
/*RLAPI*/ void rlFramebufferAttach(unsigned int fboId, unsigned int texId, int attachType, int texType, int mipLevel);  // Attach texture/renderbuffer to a framebuffer
/*RLAPI*/ bool rlFramebufferComplete(unsigned int id);                        // Verify framebuffer is complete
/*RLAPI*/ void rlUnloadFramebuffer(unsigned int id);                          // Delete framebuffer from GPU

// Shaders management
/*RLAPI*/ unsigned int rlLoadShaderCode(const char *vsCode, const char *fsCode);    // Load shader from code strings
/*RLAPI*/ unsigned int rlCompileShader(const char *shaderCode, int type);           // Compile custom shader and return shader id (type: RL_VERTEX_SHADER, RL_FRAGMENT_SHADER, RL_COMPUTE_SHADER)
/*RLAPI*/ unsigned int rlLoadShaderProgram(unsigned int vShaderId, unsigned int fShaderId); // Load custom shader program
/*RLAPI*/ void rlUnloadShaderProgram(unsigned int id);                              // Unload shader program
/*RLAPI*/ int rlGetLocationUniform(unsigned int shaderId, const char *uniformName); // Get shader location uniform
/*RLAPI*/ int rlGetLocationAttrib(unsigned int shaderId, const char *attribName);   // Get shader location attribute
/*RLAPI*/ void rlSetUniform(int locIndex, const void *value, int uniformType, int count);   // Set shader value uniform
/*RLAPI*/ void rlSetUniformMatrix(int locIndex, Matrix mat);                        // Set shader value matrix
/*RLAPI*/ void rlSetUniformSampler(int locIndex, unsigned int textureId);           // Set shader value sampler
/*RLAPI*/ void rlSetShader(unsigned int id, int *locs);                             // Set shader currently active (id and locations)

// Compute shader management
/*RLAPI*/ unsigned int rlLoadComputeShaderProgram(unsigned int shaderId);           // Load compute shader program
/*RLAPI*/ void rlComputeShaderDispatch(unsigned int groupX, unsigned int groupY, unsigned int groupZ);  // Dispatch compute shader (equivalent to *draw* for graphics pipeline)

// Shader buffer storage object management (ssbo)
/*RLAPI*/ unsigned int rlLoadShaderBuffer(unsigned int size, const void *data, int usageHint); // Load shader storage buffer object (SSBO)
/*RLAPI*/ void rlUnloadShaderBuffer(unsigned int ssboId);                           // Unload shader storage buffer object (SSBO)
/*RLAPI*/ void rlUpdateShaderBuffer(unsigned int id, const void *data, unsigned int dataSize, unsigned int offset); // Update SSBO buffer data
/*RLAPI*/ void rlBindShaderBuffer(unsigned int id, unsigned int index);             // Bind SSBO buffer
/*RLAPI*/ void rlReadShaderBuffer(unsigned int id, void *dest, unsigned int count, unsigned int offset); // Read SSBO buffer data (GPU->CPU)
/*RLAPI*/ void rlCopyShaderBuffer(unsigned int destId, unsigned int srcId, unsigned int destOffset, unsigned int srcOffset, unsigned int count); // Copy SSBO data between buffers
/*RLAPI*/ unsigned int rlGetShaderBufferSize(unsigned int id);                      // Get SSBO buffer size

// Buffer management
/*RLAPI*/ void rlBindImageTexture(unsigned int id, unsigned int index, int format, bool readonly);  // Bind image texture

// Matrix state management
/*RLAPI*/ Matrix rlGetMatrixModelview(void);                                  // Get internal modelview matrix
/*RLAPI*/ Matrix rlGetMatrixProjection(void);                                 // Get internal projection matrix
/*RLAPI*/ Matrix rlGetMatrixTransform(void);                                  // Get internal accumulated transform matrix
/*RLAPI*/ Matrix rlGetMatrixProjectionStereo(int eye);                        // Get internal projection matrix for stereo render (selected eye)
/*RLAPI*/ Matrix rlGetMatrixViewOffsetStereo(int eye);                        // Get internal view offset matrix for stereo render (selected eye)
/*RLAPI*/ void rlSetMatrixProjection(Matrix proj);                            // Set a custom projection matrix (replaces internal projection matrix)
/*RLAPI*/ void rlSetMatrixModelview(Matrix view);                             // Set a custom modelview matrix (replaces internal modelview matrix)
/*RLAPI*/ void rlSetMatrixProjectionStereo(Matrix right, Matrix left);        // Set eyes projection matrices for stereo rendering
/*RLAPI*/ void rlSetMatrixViewOffsetStereo(Matrix right, Matrix left);        // Set eyes view offsets matrices for stereo rendering

// Quick and dirty cube/quad buffers load->draw->unload
/*RLAPI*/ void rlLoadDrawCube(void);     // Load and draw a cube
/*RLAPI*/ void rlLoadDrawQuad(void);     // Load and draw a quad

RAYLIB_H;
} // RL_SUPPORT_MODULE_RLGL


if ( RL_SUPPORT_CAMERA_SYSTEM || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 ) {
$RAYLIB_H .= <<<'RAYLIB_H'

//------------------------------------------------------------------------------------
// Camera System Functions (Module: rcamera)
//------------------------------------------------------------------------------------

/*RLAPI*/ void UpdateCamera(Camera *camera, int mode);      // Update camera position for selected mode
/*RLAPI*/ void UpdateCameraPro(Camera *camera, Vector3 movement, Vector3 rotation, float zoom); // Update camera movement/rotation

/*RLAPI*/ Vector3 GetCameraForward(Camera *camera);
/*RLAPI*/ Vector3 GetCameraUp(Camera *camera);
/*RLAPI*/ Vector3 GetCameraRight(Camera *camera);

// Camera movement
/*RLAPI*/ void CameraMoveForward(Camera *camera, float distance, bool moveInWorldPlane);
/*RLAPI*/ void CameraMoveUp(Camera *camera, float distance);
/*RLAPI*/ void CameraMoveRight(Camera *camera, float distance, bool moveInWorldPlane);
/*RLAPI*/ void CameraMoveToTarget(Camera *camera, float delta);

// Camera rotation
/*RLAPI*/ void CameraYaw(Camera *camera, float angle, bool rotateAroundTarget);
/*RLAPI*/ void CameraPitch(Camera *camera, float angle, bool lockView, bool rotateAroundTarget, bool rotateUp);
/*RLAPI*/ void CameraRoll(Camera *camera, float angle);

/*RLAPI*/ Matrix GetCameraViewMatrix(Camera *camera);
/*RLAPI*/ Matrix GetCameraProjectionMatrix(Camera* camera, float aspect);

RAYLIB_H;
} // RL_SUPPORT_CAMERA_SYSTEM

if ( RL_SUPPORT_MODULE_RAYGUI || $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 )
{
/*******************************************************************************************
*
*   raygui - A simple and easy-to-use immediate-mode gui library
*
*   DESCRIPTION:
*       raygui is a tools-dev-focused immediate-mode-gui library based on raylib but also
*       available as a standalone library, as long as input and drawing functions are provided.
*
*   https://github.com/raysan5/raygui/
*
*******************************************************************************************/

define( 'RAYGUI_VERSION_MAJOR' , 3 );
define( 'RAYGUI_VERSION_MINOR' , 6 );
define( 'RAYGUI_VERSION_PATCH' , 0 );
define( 'RAYGUI_VERSION'       ,  '3.6' );


$RAYGUI_H .= <<<'RAYGUI_H'

// Style property
typedef struct GuiStyleProp {
    unsigned short controlId;
    unsigned short propertyId;
    unsigned int propertyValue;
} GuiStyleProp;

RAYGUI_H;

// Gui control state
//typedef enum {
define( 'RLGUI_STATE_NORMAL'   , 0 );
define( 'RLGUI_STATE_FOCUSED'  , 1 );
define( 'RLGUI_STATE_PRESSED'  , 2 );
define( 'RLGUI_STATE_DISABLED' , 3 );
//} GuiState;

// Gui control text alignment
//typedef enum {
define( 'RLGUI_TEXT_ALIGN_LEFT'   , 0 );
define( 'RLGUI_TEXT_ALIGN_CENTER' , 1 );
define( 'RLGUI_TEXT_ALIGN_RIGHT'  , 2 );
//} GuiTextAlignment;

// Gui controls
//typedef enum {
	// Default -> populates to all controls when set
define( 'RLGUI_DEFAULT'    ,  0 );
    // Basic controls
define( 'RLGUI_LABEL'      ,  1 ); // Used also for: LABELBUTTON
define( 'RLGUI_BUTTON'     ,  2 );
define( 'RLGUI_TOGGLE'     ,  3 ); // Used also for: TOGGLEGROUP
define( 'RLGUI_SLIDER'     ,  4 ); // Used also for: SLIDERBAR
define( 'RLGUI_PROGRESSBAR',  5 );
define( 'RLGUI_CHECKBOX'   ,  6 );
define( 'RLGUI_COMBOBOX'   ,  7 );
define( 'RLGUI_DROPDOWNBOX',  8 );
define( 'RLGUI_TEXTBOX'    ,  9 ); // Used also for: TEXTBOXMULTI
define( 'RLGUI_VALUEBOX'   , 10 );
define( 'RLGUI_SPINNER'    , 11 ); // Uses: BUTTON, VALUEBOX
define( 'RLGUI_LISTVIEW'   , 12 );
define( 'RLGUI_COLORPICKER', 13 );
define( 'RLGUI_SCROLLBAR'  , 14 );
define( 'RLGUI_STATUSBAR'  , 15 );
//} GuiControl;

// Gui base properties for every control
// NOTE: RAYGUI_MAX_PROPS_BASE properties (by default 16 properties)
//typedef enum {
define( 'RLGUI_BORDER_COLOR_NORMAL'  ,  0 );
define( 'RLGUI_BASE_COLOR_NORMAL'    ,  1 );
define( 'RLGUI_TEXT_COLOR_NORMAL'    ,  2 );
define( 'RLGUI_BORDER_COLOR_FOCUSED' ,  3 );
define( 'RLGUI_BASE_COLOR_FOCUSED'   ,  4 );
define( 'RLGUI_TEXT_COLOR_FOCUSED'   ,  5 );
define( 'RLGUI_BORDER_COLOR_PRESSED' ,  6 );
define( 'RLGUI_BASE_COLOR_PRESSED'   ,  7 );
define( 'RLGUI_TEXT_COLOR_PRESSED'   ,  8 );
define( 'RLGUI_BORDER_COLOR_DISABLED',  9 );
define( 'RLGUI_BASE_COLOR_DISABLED'  , 10 );
define( 'RLGUI_TEXT_COLOR_DISABLED'  , 11 );
define( 'RLGUI_BORDER_WIDTH'         , 12 );
define( 'RLGUI_TEXT_PADDING'         , 13 );
define( 'RLGUI_TEXT_ALIGNMENT'       , 14 );
define( 'RLGUI_RESERVED'             , 15 );
//} GuiControlProperty;

// Gui extended properties depend on control
// NOTE: RAYGUI_MAX_PROPS_EXTENDED properties (by default 8 properties)
//----------------------------------------------------------------------------------

// DEFAULT extended properties
// NOTE: Those properties are common to all controls or global
//typedef enum {
define( 'RLGUI_TEXT_SIZE'       , 16 );  // Text size (glyphs max height)
define( 'RLGUI_TEXT_SPACING'    , 17 );  // Text spacing between glyphs
define( 'RLGUI_LINE_COLOR'      , 18 );  // Line control color
define( 'RLGUI_BACKGROUND_COLOR', 19 );  // Background color
//} GuiDefaultProperty;

// Toggle/ToggleGroup
//typedef enum {
define( 'RLGUI_GROUP_PADDING'   , 16 ); // ToggleGroup separation between toggles
//} GuiToggleProperty;

// Slider/SliderBar
//typedef enum {
define( 'RLGUI_SLIDER_WIDTH',   16 ); // Slider size of internal bar
define( 'RLGUI_SLIDER_PADDING', 17 ); // Slider/SliderBar internal bar padding
//} GuiSliderProperty;

// ProgressBar
//typedef enum {
define( 'RLGUI_PROGRESS_PADDING' , 16 ); // ProgressBar internal padding
//} GuiProgressBarProperty;

// ScrollBar
//typedef enum {
define( 'RLGUI_ARROWS_SIZE'          , 16 );
define( 'RLGUI_ARROWS_VISIBLE'       , 17 );
define( 'RLGUI_SCROLL_SLIDER_PADDING', 18 ); // (SLIDERBAR, SLIDER_PADDING)
define( 'RLGUI_SCROLL_SLIDER_SIZE'   , 19 );
define( 'RLGUI_SCROLL_PADDING'       , 20 );
define( 'RLGUI_SCROLL_SPEED'         , 21 );
//} GuiScrollBarProperty;

// CheckBox
//typedef enum {
define( 'RLGUI_CHECK_PADDING'        , 16 ); // CheckBox internal check padding
//} GuiCheckBoxProperty;

// ComboBox
//typedef enum {
define( 'RLGUI_COMBO_BUTTON_WIDTH'   , 16 ); // ComboBox right button width
define( 'RLGUI_COMBO_BUTTON_SPACING' , 17 ); // ComboBox button separation
//} GuiComboBoxProperty;

// DropdownBox
//typedef enum {
define( 'RLGUI_ARROW_PADDING'          , 16 ); // DropdownBox arrow separation from border and items
define( 'RLGUI_DROPDOWN_ITEMS_SPACING' , 17 ); // DropdownBox items separation
//} GuiDropdownBoxProperty;

// TextBox/TextBoxMulti/ValueBox/Spinner
//typedef enum {
define( 'RLGUI_TEXT_INNER_PADDING'     , 16 );  // TextBox/TextBoxMulti/ValueBox/Spinner inner text padding
define( 'RLGUI_TEXT_LINES_SPACING'     , 17 );  // TextBoxMulti lines separation
define( 'RLGUI_TEXT_ALIGNMENT_VERTICAL', 18 );  // TextBoxMulti vertical alignment: 0-CENTERED, 1-UP, 2-DOWN
define( 'RLGUI_TEXT_MULTILINE'         , 19 );  // TextBox supports multiple lines
define( 'RLGUI_TEXT_WRAP_MODE'         , 20 );  // TextBox wrap mode for multiline: 0-NO_WRAP, 1-CHAR_WRAP, 2-WORD_WRAP
//} GuiTextBoxProperty;

// Spinner
//typedef enum {
define( 'RLGUI_SPIN_BUTTON_WIDTH'  , 16 ); // Spinner left/right buttons width
define( 'RLGUI_SPIN_BUTTON_SPACING', 17 ); // Spinner buttons separation
//} GuiSpinnerProperty;

// ListView
//typedef enum {
define( 'RLGUI_LIST_ITEMS_HEIGHT'  , 16 ); // ListView items height
define( 'RLGUI_LIST_ITEMS_SPACING' , 17 ); // ListView items separation
define( 'RLGUI_SCROLLBAR_WIDTH'    , 18 ); // ListView scrollbar size (usually width)
define( 'RLGUI_SCROLLBAR_SIDE'     , 19 ); // ListView scrollbar side (0-left, 1-right)
//} GuiListViewProperty;

// ColorPicker
//typedef enum {
define( 'RLGUI_COLOR_SELECTOR_SIZE'     , 16 );
define( 'RLGUI_HUEBAR_WIDTH'            , 17 ); // ColorPicker right hue bar width
define( 'RLGUI_HUEBAR_PADDING'          , 18 ); // ColorPicker right hue bar separation from panel
define( 'RLGUI_HUEBAR_SELECTOR_HEIGHT'  , 19 ); // ColorPicker right hue bar selector height
define( 'RLGUI_HUEBAR_SELECTOR_OVERFLOW', 20 ); // ColorPicker right hue bar selector overflow
//} GuiColorPickerProperty;

define( 'RLGUI_SCROLLBAR_LEFT_SIDE'  , 0 );
define( 'RLGUI_SCROLLBAR_RIGHT_SIDE' , 1 );

//----------------------------------------------------------------------------------
// Icons enumeration
//----------------------------------------------------------------------------------
//typedef enum {
define( 'RLGUI_ICON_NONE'                     , 0 );
define( 'RLGUI_ICON_FOLDER_FILE_OPEN'         , 1 );
define( 'RLGUI_ICON_FILE_SAVE_CLASSIC'        , 2 );
define( 'RLGUI_ICON_FOLDER_OPEN'              , 3 );
define( 'RLGUI_ICON_FOLDER_SAVE'              , 4 );
define( 'RLGUI_ICON_FILE_OPEN'                , 5 );
define( 'RLGUI_ICON_FILE_SAVE'                , 6 );
define( 'RLGUI_ICON_FILE_EXPORT'              , 7 );
define( 'RLGUI_ICON_FILE_ADD'                 , 8 );
define( 'RLGUI_ICON_FILE_DELETE'              , 9 );
define( 'RLGUI_ICON_FILETYPE_TEXT'            , 10 );
define( 'RLGUI_ICON_FILETYPE_AUDIO'           , 11 );
define( 'RLGUI_ICON_FILETYPE_IMAGE'           , 12 );
define( 'RLGUI_ICON_FILETYPE_PLAY'            , 13 );
define( 'RLGUI_ICON_FILETYPE_VIDEO'           , 14 );
define( 'RLGUI_ICON_FILETYPE_INFO'            , 15 );
define( 'RLGUI_ICON_FILE_COPY'                , 16 );
define( 'RLGUI_ICON_FILE_CUT'                 , 17 );
define( 'RLGUI_ICON_FILE_PASTE'               , 18 );
define( 'RLGUI_ICON_CURSOR_HAND'              , 19 );
define( 'RLGUI_ICON_CURSOR_POINTER'           , 20 );
define( 'RLGUI_ICON_CURSOR_CLASSIC'           , 21 );
define( 'RLGUI_ICON_PENCIL'                   , 22 );
define( 'RLGUI_ICON_PENCIL_BIG'               , 23 );
define( 'RLGUI_ICON_BRUSH_CLASSIC'            , 24 );
define( 'RLGUI_ICON_BRUSH_PAINTER'            , 25 );
define( 'RLGUI_ICON_WATER_DROP'               , 26 );
define( 'RLGUI_ICON_COLOR_PICKER'             , 27 );
define( 'RLGUI_ICON_RUBBER'                   , 28 );
define( 'RLGUI_ICON_COLOR_BUCKET'             , 29 );
define( 'RLGUI_ICON_TEXT_T'                   , 30 );
define( 'RLGUI_ICON_TEXT_A'                   , 31 );
define( 'RLGUI_ICON_SCALE'                    , 32 );
define( 'RLGUI_ICON_RESIZE'                   , 33 );
define( 'RLGUI_ICON_FILTER_POINT'             , 34 );
define( 'RLGUI_ICON_FILTER_BILINEAR'          , 35 );
define( 'RLGUI_ICON_CROP'                     , 36 );
define( 'RLGUI_ICON_CROP_ALPHA'               , 37 );
define( 'RLGUI_ICON_SQUARE_TOGGLE'            , 38 );
define( 'RLGUI_ICON_SYMMETRY'                 , 39 );
define( 'RLGUI_ICON_SYMMETRY_HORIZONTAL'      , 40 );
define( 'RLGUI_ICON_SYMMETRY_VERTICAL'        , 41 );
define( 'RLGUI_ICON_LENS'                     , 42 );
define( 'RLGUI_ICON_LENS_BIG'                 , 43 );
define( 'RLGUI_ICON_EYE_ON'                   , 44 );
define( 'RLGUI_ICON_EYE_OFF'                  , 45 );
define( 'RLGUI_ICON_FILTER_TOP'               , 46 );
define( 'RLGUI_ICON_FILTER'                   , 47 );
define( 'RLGUI_ICON_TARGET_POINT'             , 48 );
define( 'RLGUI_ICON_TARGET_SMALL'             , 49 );
define( 'RLGUI_ICON_TARGET_BIG'               , 50 );
define( 'RLGUI_ICON_TARGET_MOVE'              , 51 );
define( 'RLGUI_ICON_CURSOR_MOVE'              , 52 );
define( 'RLGUI_ICON_CURSOR_SCALE'             , 53 );
define( 'RLGUI_ICON_CURSOR_SCALE_RIGHT'       , 54 );
define( 'RLGUI_ICON_CURSOR_SCALE_LEFT'        , 55 );
define( 'RLGUI_ICON_UNDO'                     , 56 );
define( 'RLGUI_ICON_REDO'                     , 57 );
define( 'RLGUI_ICON_REREDO'                   , 58 );
define( 'RLGUI_ICON_MUTATE'                   , 59 );
define( 'RLGUI_ICON_ROTATE'                   , 60 );
define( 'RLGUI_ICON_REPEAT'                   , 61 );
define( 'RLGUI_ICON_SHUFFLE'                  , 62 );
define( 'RLGUI_ICON_EMPTYBOX'                 , 63 );
define( 'RLGUI_ICON_TARGET'                   , 64 );
define( 'RLGUI_ICON_TARGET_SMALL_FILL'        , 65 );
define( 'RLGUI_ICON_TARGET_BIG_FILL'          , 66 );
define( 'RLGUI_ICON_TARGET_MOVE_FILL'         , 67 );
define( 'RLGUI_ICON_CURSOR_MOVE_FILL'         , 68 );
define( 'RLGUI_ICON_CURSOR_SCALE_FILL'        , 69 );
define( 'RLGUI_ICON_CURSOR_SCALE_RIGHT_FILL'  , 70 );
define( 'RLGUI_ICON_CURSOR_SCALE_LEFT_FILL'   , 71 );
define( 'RLGUI_ICON_UNDO_FILL'                , 72 );
define( 'RLGUI_ICON_REDO_FILL'                , 73 );
define( 'RLGUI_ICON_REREDO_FILL'              , 74 );
define( 'RLGUI_ICON_MUTATE_FILL'              , 75 );
define( 'RLGUI_ICON_ROTATE_FILL'              , 76 );
define( 'RLGUI_ICON_REPEAT_FILL'              , 77 );
define( 'RLGUI_ICON_SHUFFLE_FILL'             , 78 );
define( 'RLGUI_ICON_EMPTYBOX_SMALL'           , 79 );
define( 'RLGUI_ICON_BOX'                      , 80 );
define( 'RLGUI_ICON_BOX_TOP'                  , 81 );
define( 'RLGUI_ICON_BOX_TOP_RIGHT'            , 82 );
define( 'RLGUI_ICON_BOX_RIGHT'                , 83 );
define( 'RLGUI_ICON_BOX_BOTTOM_RIGHT'         , 84 );
define( 'RLGUI_ICON_BOX_BOTTOM'               , 85 );
define( 'RLGUI_ICON_BOX_BOTTOM_LEFT'          , 86 );
define( 'RLGUI_ICON_BOX_LEFT'                 , 87 );
define( 'RLGUI_ICON_BOX_TOP_LEFT'             , 88 );
define( 'RLGUI_ICON_BOX_CENTER'               , 89 );
define( 'RLGUI_ICON_BOX_CIRCLE_MASK'          , 90 );
define( 'RLGUI_ICON_POT'                      , 91 );
define( 'RLGUI_ICON_ALPHA_MULTIPLY'           , 92 );
define( 'RLGUI_ICON_ALPHA_CLEAR'              , 93 );
define( 'RLGUI_ICON_DITHERING'                , 94 );
define( 'RLGUI_ICON_MIPMAPS'                  , 95 );
define( 'RLGUI_ICON_BOX_GRID'                 , 96 );
define( 'RLGUI_ICON_GRID'                     , 97 );
define( 'RLGUI_ICON_BOX_CORNERS_SMALL'        , 98 );
define( 'RLGUI_ICON_BOX_CORNERS_BIG'          , 99 );
define( 'RLGUI_ICON_FOUR_BOXES'               , 100 );
define( 'RLGUI_ICON_GRID_FILL'                , 101 );
define( 'RLGUI_ICON_BOX_MULTISIZE'            , 102 );
define( 'RLGUI_ICON_ZOOM_SMALL'               , 103 );
define( 'RLGUI_ICON_ZOOM_MEDIUM'              , 104 );
define( 'RLGUI_ICON_ZOOM_BIG'                 , 105 );
define( 'RLGUI_ICON_ZOOM_ALL'                 , 106 );
define( 'RLGUI_ICON_ZOOM_CENTER'              , 107 );
define( 'RLGUI_ICON_BOX_DOTS_SMALL'           , 108 );
define( 'RLGUI_ICON_BOX_DOTS_BIG'             , 109 );
define( 'RLGUI_ICON_BOX_CONCENTRIC'           , 110 );
define( 'RLGUI_ICON_BOX_GRID_BIG'             , 111 );
define( 'RLGUI_ICON_OK_TICK'                  , 112 );
define( 'RLGUI_ICON_CROSS'                    , 113 );
define( 'RLGUI_ICON_ARROW_LEFT'               , 114 );
define( 'RLGUI_ICON_ARROW_RIGHT'              , 115 );
define( 'RLGUI_ICON_ARROW_DOWN'               , 116 );
define( 'RLGUI_ICON_ARROW_UP'                 , 117 );
define( 'RLGUI_ICON_ARROW_LEFT_FILL'          , 118 );
define( 'RLGUI_ICON_ARROW_RIGHT_FILL'         , 119 );
define( 'RLGUI_ICON_ARROW_DOWN_FILL'          , 120 );
define( 'RLGUI_ICON_ARROW_UP_FILL'            , 121 );
define( 'RLGUI_ICON_AUDIO'                    , 122 );
define( 'RLGUI_ICON_FX'                       , 123 );
define( 'RLGUI_ICON_WAVE'                     , 124 );
define( 'RLGUI_ICON_WAVE_SINUS'               , 125 );
define( 'RLGUI_ICON_WAVE_SQUARE'              , 126 );
define( 'RLGUI_ICON_WAVE_TRIANGULAR'          , 127 );
define( 'RLGUI_ICON_CROSS_SMALL'              , 128 );
define( 'RLGUI_ICON_PLAYER_PREVIOUS'          , 129 );
define( 'RLGUI_ICON_PLAYER_PLAY_BACK'         , 130 );
define( 'RLGUI_ICON_PLAYER_PLAY'              , 131 );
define( 'RLGUI_ICON_PLAYER_PAUSE'             , 132 );
define( 'RLGUI_ICON_PLAYER_STOP'              , 133 );
define( 'RLGUI_ICON_PLAYER_NEXT'              , 134 );
define( 'RLGUI_ICON_PLAYER_RECORD'            , 135 );
define( 'RLGUI_ICON_MAGNET'                   , 136 );
define( 'RLGUI_ICON_LOCK_CLOSE'               , 137 );
define( 'RLGUI_ICON_LOCK_OPEN'                , 138 );
define( 'RLGUI_ICON_CLOCK'                    , 139 );
define( 'RLGUI_ICON_TOOLS'                    , 140 );
define( 'RLGUI_ICON_GEAR'                     , 141 );
define( 'RLGUI_ICON_GEAR_BIG'                 , 142 );
define( 'RLGUI_ICON_BIN'                      , 143 );
define( 'RLGUI_ICON_HAND_POINTER'             , 144 );
define( 'RLGUI_ICON_LASER'                    , 145 );
define( 'RLGUI_ICON_COIN'                     , 146 );
define( 'RLGUI_ICON_EXPLOSION'                , 147 );
define( 'RLGUI_ICON_1UP'                      , 148 );
define( 'RLGUI_ICON_PLAYER'                   , 149 );
define( 'RLGUI_ICON_PLAYER_JUMP'              , 150 );
define( 'RLGUI_ICON_KEY'                      , 151 );
define( 'RLGUI_ICON_DEMON'                    , 152 );
define( 'RLGUI_ICON_TEXT_POPUP'               , 153 );
define( 'RLGUI_ICON_GEAR_EX'                  , 154 );
define( 'RLGUI_ICON_CRACK'                    , 155 );
define( 'RLGUI_ICON_CRACK_POINTS'             , 156 );
define( 'RLGUI_ICON_STAR'                     , 157 );
define( 'RLGUI_ICON_DOOR'                     , 158 );
define( 'RLGUI_ICON_EXIT'                     , 159 );
define( 'RLGUI_ICON_MODE_2D'                  , 160 );
define( 'RLGUI_ICON_MODE_3D'                  , 161 );
define( 'RLGUI_ICON_CUBE'                     , 162 );
define( 'RLGUI_ICON_CUBE_FACE_TOP'            , 163 );
define( 'RLGUI_ICON_CUBE_FACE_LEFT'           , 164 );
define( 'RLGUI_ICON_CUBE_FACE_FRONT'          , 165 );
define( 'RLGUI_ICON_CUBE_FACE_BOTTOM'         , 166 );
define( 'RLGUI_ICON_CUBE_FACE_RIGHT'          , 167 );
define( 'RLGUI_ICON_CUBE_FACE_BACK'           , 168 );
define( 'RLGUI_ICON_CAMERA'                   , 169 );
define( 'RLGUI_ICON_SPECIAL'                  , 170 );
define( 'RLGUI_ICON_LINK_NET'                 , 171 );
define( 'RLGUI_ICON_LINK_BOXES'               , 172 );
define( 'RLGUI_ICON_LINK_MULTI'               , 173 );
define( 'RLGUI_ICON_LINK'                     , 174 );
define( 'RLGUI_ICON_LINK_BROKE'               , 175 );
define( 'RLGUI_ICON_TEXT_NOTES'               , 176 );
define( 'RLGUI_ICON_NOTEBOOK'                 , 177 );
define( 'RLGUI_ICON_SUITCASE'                 , 178 );
define( 'RLGUI_ICON_SUITCASE_ZIP'             , 179 );
define( 'RLGUI_ICON_MAILBOX'                  , 180 );
define( 'RLGUI_ICON_MONITOR'                  , 181 );
define( 'RLGUI_ICON_PRINTER'                  , 182 );
define( 'RLGUI_ICON_PHOTO_CAMERA'             , 183 );
define( 'RLGUI_ICON_PHOTO_CAMERA_FLASH'       , 184 );
define( 'RLGUI_ICON_HOUSE'                    , 185 );
define( 'RLGUI_ICON_HEART'                    , 186 );
define( 'RLGUI_ICON_CORNER'                   , 187 );
define( 'RLGUI_ICON_VERTICAL_BARS'            , 188 );
define( 'RLGUI_ICON_VERTICAL_BARS_FILL'       , 189 );
define( 'RLGUI_ICON_LIFE_BARS'                , 190 );
define( 'RLGUI_ICON_INFO'                     , 191 );
define( 'RLGUI_ICON_CROSSLINE'                , 192 );
define( 'RLGUI_ICON_HELP'                     , 193 );
define( 'RLGUI_ICON_FILETYPE_ALPHA'           , 194 );
define( 'RLGUI_ICON_FILETYPE_HOME'            , 195 );
define( 'RLGUI_ICON_LAYERS_VISIBLE'           , 196 );
define( 'RLGUI_ICON_LAYERS'                   , 197 );
define( 'RLGUI_ICON_WINDOW'                   , 198 );
define( 'RLGUI_ICON_HIDPI'                    , 199 );
define( 'RLGUI_ICON_FILETYPE_BINARY'          , 200 );
define( 'RLGUI_ICON_HEX'                      , 201 );
define( 'RLGUI_ICON_SHIELD'                   , 202 );
define( 'RLGUI_ICON_FILE_NEW'                 , 203 );
define( 'RLGUI_ICON_FOLDER_ADD'               , 204 );
define( 'RLGUI_ICON_ALARM'                    , 205 );
define( 'RLGUI_ICON_CPU'                      , 206 );
define( 'RLGUI_ICON_ROM'                      , 207 );
define( 'RLGUI_ICON_STEP_OVER'                , 208 );
define( 'RLGUI_ICON_STEP_INTO'                , 209 );
define( 'RLGUI_ICON_STEP_OUT'                 , 210 );
define( 'RLGUI_ICON_RESTART'                  , 211 );
define( 'RLGUI_ICON_BREAKPOINT_ON'            , 212 );
define( 'RLGUI_ICON_BREAKPOINT_OFF'           , 213 );
define( 'RLGUI_ICON_BURGER_MENU'              , 214 );
define( 'RLGUI_ICON_CASE_SENSITIVE'           , 215 );
define( 'RLGUI_ICON_REG_EXP'                  , 216 );
define( 'RLGUI_ICON_FOLDER'                   , 217 );
define( 'RLGUI_ICON_FILE'                     , 218 );
define( 'RLGUI_ICON_SAND_TIMER'               , 219 );
define( 'RLGUI_ICON_220'                      , 220 );
define( 'RLGUI_ICON_221'                      , 221 );
define( 'RLGUI_ICON_222'                      , 222 );
define( 'RLGUI_ICON_223'                      , 223 );
define( 'RLGUI_ICON_224'                      , 224 );
define( 'RLGUI_ICON_225'                      , 225 );
define( 'RLGUI_ICON_226'                      , 226 );
define( 'RLGUI_ICON_227'                      , 227 );
define( 'RLGUI_ICON_228'                      , 228 );
define( 'RLGUI_ICON_229'                      , 229 );
define( 'RLGUI_ICON_230'                      , 230 );
define( 'RLGUI_ICON_231'                      , 231 );
define( 'RLGUI_ICON_232'                      , 232 );
define( 'RLGUI_ICON_233'                      , 233 );
define( 'RLGUI_ICON_234'                      , 234 );
define( 'RLGUI_ICON_235'                      , 235 );
define( 'RLGUI_ICON_236'                      , 236 );
define( 'RLGUI_ICON_237'                      , 237 );
define( 'RLGUI_ICON_238'                      , 238 );
define( 'RLGUI_ICON_239'                      , 239 );
define( 'RLGUI_ICON_240'                      , 240 );
define( 'RLGUI_ICON_241'                      , 241 );
define( 'RLGUI_ICON_242'                      , 242 );
define( 'RLGUI_ICON_243'                      , 243 );
define( 'RLGUI_ICON_244'                      , 244 );
define( 'RLGUI_ICON_245'                      , 245 );
define( 'RLGUI_ICON_246'                      , 246 );
define( 'RLGUI_ICON_247'                      , 247 );
define( 'RLGUI_ICON_248'                      , 248 );
define( 'RLGUI_ICON_249'                      , 249 );
define( 'RLGUI_ICON_250'                      , 250 );
define( 'RLGUI_ICON_251'                      , 251 );
define( 'RLGUI_ICON_252'                      , 252 );
define( 'RLGUI_ICON_253'                      , 253 );
define( 'RLGUI_ICON_254'                      , 254 );
define( 'RLGUI_ICON_255'                      , 255 );
//} GuiIconName;



$RAYGUI_H .= <<<'RAYGUI_H'

// Global gui state control functions
/*RAYGUIAPI*/ void GuiEnable(void);                                 // Enable gui controls (global state)
/*RAYGUIAPI*/ void GuiDisable(void);                                // Disable gui controls (global state)
/*RAYGUIAPI*/ void GuiLock(void);                                   // Lock gui controls (global state)
/*RAYGUIAPI*/ void GuiUnlock(void);                                 // Unlock gui controls (global state)
/*RAYGUIAPI*/ bool GuiIsLocked(void);                               // Check if gui is locked (global state)
/*RAYGUIAPI*/ void GuiFade(float alpha);                            // Set gui controls alpha (global state), alpha goes from 0.0f to 1.0f
/*RAYGUIAPI*/ void GuiSetState(int state);                          // Set gui state (global state)
/*RAYGUIAPI*/ int GuiGetState(void);                                // Get gui state (global state)

// Font set/get functions
/*RAYGUIAPI*/ void GuiSetFont(Font font);                           // Set gui custom font (global state)
/*RAYGUIAPI*/ Font GuiGetFont(void);                                // Get gui custom font (global state)

// Style set/get functions
/*RAYGUIAPI*/ void GuiSetStyle(int control, int property, int value);   // Set one style property
/*RAYGUIAPI*/ int GuiGetStyle(int control, int property);               // Get one style property

// Container/separator controls, useful for controls organization
/*RAYGUIAPI*/ bool GuiWindowBox(Rectangle bounds, const char *title);                                       // Window Box control, shows a window that can be closed
/*RAYGUIAPI*/ void GuiGroupBox(Rectangle bounds, const char *text);                                         // Group Box control with text name
/*RAYGUIAPI*/ void GuiLine(Rectangle bounds, const char *text);                                             // Line separator control, could contain text
/*RAYGUIAPI*/ void GuiPanel(Rectangle bounds, const char *text);                                            // Panel control, useful to group controls
/*RAYGUIAPI*/ int GuiTabBar(Rectangle bounds, const char **text, int count, int *active);                   // Tab Bar control, returns TAB to be closed or -1
/*RAYGUIAPI*/ Rectangle GuiScrollPanel(Rectangle bounds, const char *text, Rectangle content, Vector2 *scroll); // Scroll Panel control

// Basic controls set
/*RAYGUIAPI*/ void GuiLabel(Rectangle bounds, const char *text);                                            // Label control, shows text
/*RAYGUIAPI*/ bool GuiButton(Rectangle bounds, const char *text);                                           // Button control, returns true when clicked
/*RAYGUIAPI*/ bool GuiLabelButton(Rectangle bounds, const char *text);                                      // Label button control, show true when clicked
/*RAYGUIAPI*/ bool GuiToggle(Rectangle bounds, const char *text, bool active);                              // Toggle Button control, returns true when active
/*RAYGUIAPI*/ int GuiToggleGroup(Rectangle bounds, const char *text, int active);                           // Toggle Group control, returns active toggle index
/*RAYGUIAPI*/ bool GuiCheckBox(Rectangle bounds, const char *text, bool checked);                           // Check Box control, returns true when active
/*RAYGUIAPI*/ int GuiComboBox(Rectangle bounds, const char *text, int active);                              // Combo Box control, returns selected item index
/*RAYGUIAPI*/ bool GuiDropdownBox(Rectangle bounds, const char *text, int *active, bool editMode);          // Dropdown Box control, returns selected item
/*RAYGUIAPI*/ bool GuiSpinner(Rectangle bounds, const char *text, int *value, int minValue, int maxValue, bool editMode); // Spinner control, returns selected value
/*RAYGUIAPI*/ bool GuiValueBox(Rectangle bounds, const char *text, int *value, int minValue, int maxValue, bool editMode); // Value Box control, updates input text with numbers
/*RAYGUIAPI*/ bool GuiTextBox(Rectangle bounds, char *text, int textSize, bool editMode);                   // Text Box control, updates input text
/*RAYGUIAPI*/ float GuiSlider(Rectangle bounds, const char *textLeft, const char *textRight, float value, float minValue, float maxValue); // Slider control, returns selected value
/*RAYGUIAPI*/ float GuiSliderBar(Rectangle bounds, const char *textLeft, const char *textRight, float value, float minValue, float maxValue); // Slider Bar control, returns selected value
/*RAYGUIAPI*/ float GuiProgressBar(Rectangle bounds, const char *textLeft, const char *textRight, float value, float minValue, float maxValue); // Progress Bar control, shows current progress value
/*RAYGUIAPI*/ void GuiStatusBar(Rectangle bounds, const char *text);                                        // Status Bar control, shows info text
/*RAYGUIAPI*/ void GuiDummyRec(Rectangle bounds, const char *text);                                         // Dummy control for placeholders
/*RAYGUIAPI*/ Vector2 GuiGrid(Rectangle bounds, const char *text, float spacing, int subdivs);              // Grid control, returns mouse cell position

// Advance controls set
/*RAYGUIAPI*/ int GuiListView(Rectangle bounds, const char *text, int *scrollIndex, int active);            // List View control, returns selected list item index
/*RAYGUIAPI*/ int GuiListViewEx(Rectangle bounds, const char **text, int count, int *focus, int *scrollIndex, int active); // List View with extended parameters
/*RAYGUIAPI*/ int GuiMessageBox(Rectangle bounds, const char *title, const char *message, const char *buttons); // Message Box control, displays a message
/*RAYGUIAPI*/ int GuiTextInputBox(Rectangle bounds, const char *title, const char *message, const char *buttons, char *text, int textMaxSize, int *secretViewActive); // Text Input Box control, ask for text, supports secret
/*RAYGUIAPI*/ Color GuiColorPicker(Rectangle bounds, const char *text, Color color);                        // Color Picker control (multiple color controls)
/*RAYGUIAPI*/ Color GuiColorPanel(Rectangle bounds, const char *text, Color color);                         // Color Panel control
/*RAYGUIAPI*/ float GuiColorBarAlpha(Rectangle bounds, const char *text, float alpha);                      // Color Bar Alpha control
/*RAYGUIAPI*/ float GuiColorBarHue(Rectangle bounds, const char *text, float value);                        // Color Bar Hue control

// Styles loading functions
/*RAYGUIAPI*/ void GuiLoadStyle(const char *fileName);              // Load style file over global style variable (.rgs)
/*RAYGUIAPI*/ void GuiLoadStyleDefault(void);                       // Load style default over global style

// Tooltips management functions
/*RAYGUIAPI*/ void GuiEnableTooltip(void);                          // Enable gui tooltips (global state)
/*RAYGUIAPI*/ void GuiDisableTooltip(void);                         // Disable gui tooltips (global state)
/*RAYGUIAPI*/ void GuiSetTooltip(const char *tooltip);              // Set tooltip string

// Icons functionality
/*RAYGUIAPI*/ const char *GuiIconText(int iconId, const char *text); // Get text with icon id prepended (if supported)


/*RAYGUIAPI*/ void GuiSetIconScale(int scale);                      // Set default icon drawing size
/*RAYGUIAPI*/ unsigned int *GuiGetIcons(void);                      // Get raygui icons data pointer
/*RAYGUIAPI*/ char **GuiLoadIcons(const char *fileName, bool loadIconsName); // Load raygui icons file (.rgi) into internal icons data
/*RAYGUIAPI*/ void GuiDrawIcon(int iconId, int posX, int posY, int pixelSize, Color color); // Draw icon using pixel size at specified position

RAYGUI_H;

} // endif RL_SUPPORT_MODULE_RAYGUI

// ---------------------------------------------


$RAYLIB_FFI = FFI::cdef( $RAYLIB_H.PHP_EOL.$RAYGUI_H , $_RAYLIB_PATH );

$RLAPI_BLACKLISTED_FUNCTIONS = [
	'SetAudioStreamCallback',
	'AttachAudioStreamProcessor',
	'DetachAudioStreamProcessor',
	'AttachAudioMixedProcessor',
	'DetachAudioMixedProcessor',

	'SetTraceLogCallback', // XXX problem with va_list parameters

	'SetLoadFileDataCallback',
	'SetSaveFileDataCallback',
	'SetLoadFileTextCallback',
	'SetSaveFileTextCallback',

	'LoadFileData'  , // handwritten
	'UnloadFileData', // handwritten

	'LoadFontEx' , // handwritten
];

//typedef Camera3D Camera;    // Camera type fallback, defaults to Camera3D
function RL_Camera( ...$_ ) : object { return RL_Camera3D( ...$_ ); }
function RL_Camera_array( ...$_ ) : object { return RL_Camera3D_array( ...$_ ); }

/// Load file data as byte array (read)
// unsigned char *LoadFileData(const char *fileName, unsigned int *bytesRead);
function RL_LoadFileData( string $FILE_PATH , int &$DATA_SIZE ) : ?object
{
	global $RAYLIB_FFI ;
	$INT = FFI::new('unsigned int[1]');
	$DATA = $RAYLIB_FFI->LoadFileData( $FILE_PATH , FFI::addr( $INT[0] ) );
	$DATA_SIZE = $INT[0] ;
	return $DATA ;
}

/// Unload file data allocated by LoadFileData()
// void UnloadFileData(unsigned char* data);
function RL_UnloadFileData( object $data ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadFileData( $data ); }

/// Load font from file with extended parameters, use NULL for fontChars and 0 for glyphCount to load the default character set
// Font LoadFontEx(const char* fileName , int fontSize , int* fontChars , int glyphCount);
function RL_LoadFontEx( string $fileName , int $fontSize , array $fontChars = null , int $glyphCount = null ) : object
{
	global $RAYLIB_FFI;

	if ( empty( $fontChars ) )
	{
		$fontChars_C = NULL ;
		$glyphCount ??= 0 ;
	}
	else
	{
		$glyphCount ??= count( $fontChars );
		$fontChars_C = FFI::new("int[ $glyphCount ]");
		for( $i = 0 ; $i < $glyphCount ; $i++ ) $fontChars_C[ $i ] = (int)$fontChars[ $i ] ;
	}

	return $RAYLIB_FFI->LoadFontEx( $fileName , $fontSize , $fontChars_C , $glyphCount );
}

// ------------------------------------------------------------------------------------
/*
	The comment line below marks the begining of an autogenerated section.
	Handmade modifications made below will be lost if the script is rebuild.

	Functions requiring handmade modifications must be blacklisted int the list above
	and their manual implementation must be inserted outside the section below.

	The code responsible for the autogeneration is located at the end of this script.
*/
//------------------------[RLAPI_WRAPPER_AUTOGENERATED]---------------------------------

define( 'RAYLIB_FFI_float3' , $RAYLIB_FFI->type( 'float3' ) );
function RL_float3( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_float3 ); $FIELDS = RAYLIB_FFI_float3->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_float3_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_float3 , $DIMENSIONS ) ); return $ARR ; }
function RL_float3_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_float3 , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_float16' , $RAYLIB_FFI->type( 'float16' ) );
function RL_float16( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_float16 ); $FIELDS = RAYLIB_FFI_float16->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_float16_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_float16 , $DIMENSIONS ) ); return $ARR ; }
function RL_float16_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_float16 , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Vector2' , $RAYLIB_FFI->type( 'Vector2' ) );
function RL_Vector2( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Vector2 ); $FIELDS = RAYLIB_FFI_Vector2->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Vector2_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Vector2 , $DIMENSIONS ) ); return $ARR ; }
function RL_Vector2_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Vector2 , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Vector3' , $RAYLIB_FFI->type( 'Vector3' ) );
function RL_Vector3( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Vector3 ); $FIELDS = RAYLIB_FFI_Vector3->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Vector3_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Vector3 , $DIMENSIONS ) ); return $ARR ; }
function RL_Vector3_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Vector3 , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Vector4' , $RAYLIB_FFI->type( 'Vector4' ) );
function RL_Vector4( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Vector4 ); $FIELDS = RAYLIB_FFI_Vector4->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Vector4_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Vector4 , $DIMENSIONS ) ); return $ARR ; }
function RL_Vector4_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Vector4 , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Matrix' , $RAYLIB_FFI->type( 'Matrix' ) );
function RL_Matrix( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Matrix ); $FIELDS = RAYLIB_FFI_Matrix->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Matrix_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Matrix , $DIMENSIONS ) ); return $ARR ; }
function RL_Matrix_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Matrix , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Color' , $RAYLIB_FFI->type( 'Color' ) );
function RL_Color( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Color ); $FIELDS = RAYLIB_FFI_Color->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Color_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Color , $DIMENSIONS ) ); return $ARR ; }
function RL_Color_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Color , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Rectangle' , $RAYLIB_FFI->type( 'Rectangle' ) );
function RL_Rectangle( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Rectangle ); $FIELDS = RAYLIB_FFI_Rectangle->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Rectangle_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Rectangle , $DIMENSIONS ) ); return $ARR ; }
function RL_Rectangle_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Rectangle , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Image' , $RAYLIB_FFI->type( 'Image' ) );
function RL_Image( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Image ); $FIELDS = RAYLIB_FFI_Image->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Image_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Image , $DIMENSIONS ) ); return $ARR ; }
function RL_Image_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Image , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Texture' , $RAYLIB_FFI->type( 'Texture' ) );
function RL_Texture( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Texture ); $FIELDS = RAYLIB_FFI_Texture->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Texture_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Texture , $DIMENSIONS ) ); return $ARR ; }
function RL_Texture_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Texture , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_RenderTexture' , $RAYLIB_FFI->type( 'RenderTexture' ) );
function RL_RenderTexture( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_RenderTexture ); $FIELDS = RAYLIB_FFI_RenderTexture->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_RenderTexture_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_RenderTexture , $DIMENSIONS ) ); return $ARR ; }
function RL_RenderTexture_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_RenderTexture , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_NPatchInfo' , $RAYLIB_FFI->type( 'NPatchInfo' ) );
function RL_NPatchInfo( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_NPatchInfo ); $FIELDS = RAYLIB_FFI_NPatchInfo->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_NPatchInfo_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_NPatchInfo , $DIMENSIONS ) ); return $ARR ; }
function RL_NPatchInfo_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_NPatchInfo , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_GlyphInfo' , $RAYLIB_FFI->type( 'GlyphInfo' ) );
function RL_GlyphInfo( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_GlyphInfo ); $FIELDS = RAYLIB_FFI_GlyphInfo->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_GlyphInfo_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_GlyphInfo , $DIMENSIONS ) ); return $ARR ; }
function RL_GlyphInfo_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_GlyphInfo , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Font' , $RAYLIB_FFI->type( 'Font' ) );
function RL_Font( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Font ); $FIELDS = RAYLIB_FFI_Font->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Font_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Font , $DIMENSIONS ) ); return $ARR ; }
function RL_Font_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Font , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Camera3D' , $RAYLIB_FFI->type( 'Camera3D' ) );
function RL_Camera3D( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Camera3D ); $FIELDS = RAYLIB_FFI_Camera3D->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Camera3D_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Camera3D , $DIMENSIONS ) ); return $ARR ; }
function RL_Camera3D_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Camera3D , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Camera2D' , $RAYLIB_FFI->type( 'Camera2D' ) );
function RL_Camera2D( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Camera2D ); $FIELDS = RAYLIB_FFI_Camera2D->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Camera2D_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Camera2D , $DIMENSIONS ) ); return $ARR ; }
function RL_Camera2D_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Camera2D , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Mesh' , $RAYLIB_FFI->type( 'Mesh' ) );
function RL_Mesh( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Mesh ); $FIELDS = RAYLIB_FFI_Mesh->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Mesh_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Mesh , $DIMENSIONS ) ); return $ARR ; }
function RL_Mesh_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Mesh , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Shader' , $RAYLIB_FFI->type( 'Shader' ) );
function RL_Shader( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Shader ); $FIELDS = RAYLIB_FFI_Shader->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Shader_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Shader , $DIMENSIONS ) ); return $ARR ; }
function RL_Shader_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Shader , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_MaterialMap' , $RAYLIB_FFI->type( 'MaterialMap' ) );
function RL_MaterialMap( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_MaterialMap ); $FIELDS = RAYLIB_FFI_MaterialMap->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_MaterialMap_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_MaterialMap , $DIMENSIONS ) ); return $ARR ; }
function RL_MaterialMap_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_MaterialMap , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Material' , $RAYLIB_FFI->type( 'Material' ) );
function RL_Material( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Material ); $FIELDS = RAYLIB_FFI_Material->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Material_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Material , $DIMENSIONS ) ); return $ARR ; }
function RL_Material_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Material , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Transform' , $RAYLIB_FFI->type( 'Transform' ) );
function RL_Transform( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Transform ); $FIELDS = RAYLIB_FFI_Transform->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Transform_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Transform , $DIMENSIONS ) ); return $ARR ; }
function RL_Transform_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Transform , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_BoneInfo' , $RAYLIB_FFI->type( 'BoneInfo' ) );
function RL_BoneInfo( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_BoneInfo ); $FIELDS = RAYLIB_FFI_BoneInfo->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_BoneInfo_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_BoneInfo , $DIMENSIONS ) ); return $ARR ; }
function RL_BoneInfo_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_BoneInfo , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Model' , $RAYLIB_FFI->type( 'Model' ) );
function RL_Model( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Model ); $FIELDS = RAYLIB_FFI_Model->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Model_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Model , $DIMENSIONS ) ); return $ARR ; }
function RL_Model_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Model , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_ModelAnimation' , $RAYLIB_FFI->type( 'ModelAnimation' ) );
function RL_ModelAnimation( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_ModelAnimation ); $FIELDS = RAYLIB_FFI_ModelAnimation->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_ModelAnimation_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_ModelAnimation , $DIMENSIONS ) ); return $ARR ; }
function RL_ModelAnimation_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_ModelAnimation , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Ray' , $RAYLIB_FFI->type( 'Ray' ) );
function RL_Ray( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Ray ); $FIELDS = RAYLIB_FFI_Ray->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Ray_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Ray , $DIMENSIONS ) ); return $ARR ; }
function RL_Ray_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Ray , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_RayCollision' , $RAYLIB_FFI->type( 'RayCollision' ) );
function RL_RayCollision( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_RayCollision ); $FIELDS = RAYLIB_FFI_RayCollision->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_RayCollision_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_RayCollision , $DIMENSIONS ) ); return $ARR ; }
function RL_RayCollision_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_RayCollision , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_BoundingBox' , $RAYLIB_FFI->type( 'BoundingBox' ) );
function RL_BoundingBox( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_BoundingBox ); $FIELDS = RAYLIB_FFI_BoundingBox->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_BoundingBox_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_BoundingBox , $DIMENSIONS ) ); return $ARR ; }
function RL_BoundingBox_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_BoundingBox , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Wave' , $RAYLIB_FFI->type( 'Wave' ) );
function RL_Wave( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Wave ); $FIELDS = RAYLIB_FFI_Wave->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Wave_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Wave , $DIMENSIONS ) ); return $ARR ; }
function RL_Wave_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Wave , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_AudioStream' , $RAYLIB_FFI->type( 'AudioStream' ) );
function RL_AudioStream( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_AudioStream ); $FIELDS = RAYLIB_FFI_AudioStream->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_AudioStream_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_AudioStream , $DIMENSIONS ) ); return $ARR ; }
function RL_AudioStream_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_AudioStream , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Sound' , $RAYLIB_FFI->type( 'Sound' ) );
function RL_Sound( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Sound ); $FIELDS = RAYLIB_FFI_Sound->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Sound_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Sound , $DIMENSIONS ) ); return $ARR ; }
function RL_Sound_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Sound , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_Music' , $RAYLIB_FFI->type( 'Music' ) );
function RL_Music( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_Music ); $FIELDS = RAYLIB_FFI_Music->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_Music_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Music , $DIMENSIONS ) ); return $ARR ; }
function RL_Music_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_Music , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_VrDeviceInfo' , $RAYLIB_FFI->type( 'VrDeviceInfo' ) );
function RL_VrDeviceInfo( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_VrDeviceInfo ); $FIELDS = RAYLIB_FFI_VrDeviceInfo->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_VrDeviceInfo_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_VrDeviceInfo , $DIMENSIONS ) ); return $ARR ; }
function RL_VrDeviceInfo_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_VrDeviceInfo , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_VrStereoConfig' , $RAYLIB_FFI->type( 'VrStereoConfig' ) );
function RL_VrStereoConfig( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_VrStereoConfig ); $FIELDS = RAYLIB_FFI_VrStereoConfig->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_VrStereoConfig_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_VrStereoConfig , $DIMENSIONS ) ); return $ARR ; }
function RL_VrStereoConfig_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_VrStereoConfig , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_FilePathList' , $RAYLIB_FFI->type( 'FilePathList' ) );
function RL_FilePathList( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_FilePathList ); $FIELDS = RAYLIB_FFI_FilePathList->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_FilePathList_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_FilePathList , $DIMENSIONS ) ); return $ARR ; }
function RL_FilePathList_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_FilePathList , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_rlVertexBuffer' , $RAYLIB_FFI->type( 'rlVertexBuffer' ) );
function RL_rlVertexBuffer( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_rlVertexBuffer ); $FIELDS = RAYLIB_FFI_rlVertexBuffer->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_rlVertexBuffer_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_rlVertexBuffer , $DIMENSIONS ) ); return $ARR ; }
function RL_rlVertexBuffer_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_rlVertexBuffer , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_rlDrawCall' , $RAYLIB_FFI->type( 'rlDrawCall' ) );
function RL_rlDrawCall( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_rlDrawCall ); $FIELDS = RAYLIB_FFI_rlDrawCall->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_rlDrawCall_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_rlDrawCall , $DIMENSIONS ) ); return $ARR ; }
function RL_rlDrawCall_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_rlDrawCall , $DIMENSIONS ) , false , true ); return $ARR ; }

define( 'RAYLIB_FFI_rlRenderBatch' , $RAYLIB_FFI->type( 'rlRenderBatch' ) );
function RL_rlRenderBatch( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_rlRenderBatch ); $FIELDS = RAYLIB_FFI_rlRenderBatch->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_rlRenderBatch_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_rlRenderBatch , $DIMENSIONS ) ); return $ARR ; }
function RL_rlRenderBatch_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_rlRenderBatch , $DIMENSIONS ) , false , true ); return $ARR ; }

/// Initialize window and OpenGL context
// void InitWindow(int width , int height , const char* title);
function RL_InitWindow( int $width , int $height , string $title ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->InitWindow( $width , $height , $title ); }

/// Check if KEY_ESCAPE pressed or Close icon pressed
// bool WindowShouldClose(void);
function RL_WindowShouldClose(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->WindowShouldClose(  ); }

/// Close window and unload OpenGL context
// void CloseWindow(void);
function RL_CloseWindow(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->CloseWindow(  ); }

/// Check if window has been initialized successfully
// bool IsWindowReady(void);
function RL_IsWindowReady(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsWindowReady(  ); }

/// Check if window is currently fullscreen
// bool IsWindowFullscreen(void);
function RL_IsWindowFullscreen(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsWindowFullscreen(  ); }

/// Check if window is currently hidden (only PLATFORM_DESKTOP)
// bool IsWindowHidden(void);
function RL_IsWindowHidden(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsWindowHidden(  ); }

/// Check if window is currently minimized (only PLATFORM_DESKTOP)
// bool IsWindowMinimized(void);
function RL_IsWindowMinimized(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsWindowMinimized(  ); }

/// Check if window is currently maximized (only PLATFORM_DESKTOP)
// bool IsWindowMaximized(void);
function RL_IsWindowMaximized(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsWindowMaximized(  ); }

/// Check if window is currently focused (only PLATFORM_DESKTOP)
// bool IsWindowFocused(void);
function RL_IsWindowFocused(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsWindowFocused(  ); }

/// Check if window has been resized last frame
// bool IsWindowResized(void);
function RL_IsWindowResized(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsWindowResized(  ); }

/// Check if one specific window flag is enabled
// bool IsWindowState(unsigned int flag);
function RL_IsWindowState( int $flag ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsWindowState( $flag ); }

/// Set window configuration state using flags (only PLATFORM_DESKTOP)
// void SetWindowState(unsigned int flags);
function RL_SetWindowState( int $flags ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetWindowState( $flags ); }

/// Clear window configuration state flags
// void ClearWindowState(unsigned int flags);
function RL_ClearWindowState( int $flags ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ClearWindowState( $flags ); }

/// Toggle window state: fullscreen/windowed (only PLATFORM_DESKTOP)
// void ToggleFullscreen(void);
function RL_ToggleFullscreen(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ToggleFullscreen(  ); }

/// Set window state: maximized, if resizable (only PLATFORM_DESKTOP)
// void MaximizeWindow(void);
function RL_MaximizeWindow(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->MaximizeWindow(  ); }

/// Set window state: minimized, if resizable (only PLATFORM_DESKTOP)
// void MinimizeWindow(void);
function RL_MinimizeWindow(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->MinimizeWindow(  ); }

/// Set window state: not minimized/maximized (only PLATFORM_DESKTOP)
// void RestoreWindow(void);
function RL_RestoreWindow(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->RestoreWindow(  ); }

/// Set icon for window (single image, RGBA 32bit, only PLATFORM_DESKTOP)
// void SetWindowIcon(Image image);
function RL_SetWindowIcon( object $image ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetWindowIcon( $image ); }

/// Set icon for window (multiple images, RGBA 32bit, only PLATFORM_DESKTOP)
// void SetWindowIcons(Image* images , int count);
function RL_SetWindowIcons( object /*ref*/$images , int $count ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetWindowIcons( FFI::addr($images) , $count ); }

/// Set title for window (only PLATFORM_DESKTOP)
// void SetWindowTitle(const char* title);
function RL_SetWindowTitle( string $title ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetWindowTitle( $title ); }

/// Set window position on screen (only PLATFORM_DESKTOP)
// void SetWindowPosition(int x , int y);
function RL_SetWindowPosition( int $x , int $y ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetWindowPosition( $x , $y ); }

/// Set monitor for the current window (fullscreen mode)
// void SetWindowMonitor(int monitor);
function RL_SetWindowMonitor( int $monitor ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetWindowMonitor( $monitor ); }

/// Set window minimum dimensions (for FLAG_WINDOW_RESIZABLE)
// void SetWindowMinSize(int width , int height);
function RL_SetWindowMinSize( int $width , int $height ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetWindowMinSize( $width , $height ); }

/// Set window dimensions
// void SetWindowSize(int width , int height);
function RL_SetWindowSize( int $width , int $height ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetWindowSize( $width , $height ); }

/// Set window opacity [0.0f..1.0f] (only PLATFORM_DESKTOP)
// void SetWindowOpacity(float opacity);
function RL_SetWindowOpacity( float $opacity ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetWindowOpacity( $opacity ); }

/// Get native window handle
// void* GetWindowHandle(void);
function RL_GetWindowHandle(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetWindowHandle(  ); }

/// Get current screen width
// int GetScreenWidth(void);
function RL_GetScreenWidth(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetScreenWidth(  ); }

/// Get current screen height
// int GetScreenHeight(void);
function RL_GetScreenHeight(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetScreenHeight(  ); }

/// Get current render width (it considers HiDPI)
// int GetRenderWidth(void);
function RL_GetRenderWidth(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetRenderWidth(  ); }

/// Get current render height (it considers HiDPI)
// int GetRenderHeight(void);
function RL_GetRenderHeight(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetRenderHeight(  ); }

/// Get number of connected monitors
// int GetMonitorCount(void);
function RL_GetMonitorCount(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMonitorCount(  ); }

/// Get current connected monitor
// int GetCurrentMonitor(void);
function RL_GetCurrentMonitor(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCurrentMonitor(  ); }

/// Get specified monitor position
// Vector2 GetMonitorPosition(int monitor);
function RL_GetMonitorPosition( int $monitor ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMonitorPosition( $monitor ); }

/// Get specified monitor width (current video mode used by monitor)
// int GetMonitorWidth(int monitor);
function RL_GetMonitorWidth( int $monitor ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMonitorWidth( $monitor ); }

/// Get specified monitor height (current video mode used by monitor)
// int GetMonitorHeight(int monitor);
function RL_GetMonitorHeight( int $monitor ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMonitorHeight( $monitor ); }

/// Get specified monitor physical width in millimetres
// int GetMonitorPhysicalWidth(int monitor);
function RL_GetMonitorPhysicalWidth( int $monitor ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMonitorPhysicalWidth( $monitor ); }

/// Get specified monitor physical height in millimetres
// int GetMonitorPhysicalHeight(int monitor);
function RL_GetMonitorPhysicalHeight( int $monitor ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMonitorPhysicalHeight( $monitor ); }

/// Get specified monitor refresh rate
// int GetMonitorRefreshRate(int monitor);
function RL_GetMonitorRefreshRate( int $monitor ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMonitorRefreshRate( $monitor ); }

/// Get window position XY on monitor
// Vector2 GetWindowPosition(void);
function RL_GetWindowPosition(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetWindowPosition(  ); }

/// Get window scale DPI factor
// Vector2 GetWindowScaleDPI(void);
function RL_GetWindowScaleDPI(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetWindowScaleDPI(  ); }

/// Get the human-readable, UTF-8 encoded name of the primary monitor
// const char* GetMonitorName(int monitor);
function RL_GetMonitorName( int $monitor ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMonitorName( $monitor ); }

/// Set clipboard text content
// void SetClipboardText(const char* text);
function RL_SetClipboardText( string $text ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetClipboardText( $text ); }

/// Get clipboard text content
// const char* GetClipboardText(void);
function RL_GetClipboardText(  ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GetClipboardText(  ); }

/// Enable waiting for events on EndDrawing(), no automatic event polling
// void EnableEventWaiting(void);
function RL_EnableEventWaiting(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->EnableEventWaiting(  ); }

/// Disable waiting for events on EndDrawing(), automatic events polling
// void DisableEventWaiting(void);
function RL_DisableEventWaiting(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DisableEventWaiting(  ); }

/// Swap back buffer with front buffer (screen drawing)
// void SwapScreenBuffer(void);
function RL_SwapScreenBuffer(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SwapScreenBuffer(  ); }

/// Register all input events
// void PollInputEvents(void);
function RL_PollInputEvents(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->PollInputEvents(  ); }

/// Wait for some time (halt program execution)
// void WaitTime(double seconds);
function RL_WaitTime( float $seconds ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->WaitTime( $seconds ); }

/// Shows cursor
// void ShowCursor(void);
function RL_ShowCursor(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ShowCursor(  ); }

/// Hides cursor
// void HideCursor(void);
function RL_HideCursor(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->HideCursor(  ); }

/// Check if cursor is not visible
// bool IsCursorHidden(void);
function RL_IsCursorHidden(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsCursorHidden(  ); }

/// Enables cursor (unlock cursor)
// void EnableCursor(void);
function RL_EnableCursor(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->EnableCursor(  ); }

/// Disables cursor (lock cursor)
// void DisableCursor(void);
function RL_DisableCursor(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DisableCursor(  ); }

/// Check if cursor is on the screen
// bool IsCursorOnScreen(void);
function RL_IsCursorOnScreen(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsCursorOnScreen(  ); }

/// Set background color (framebuffer clear color)
// void ClearBackground(Color color);
function RL_ClearBackground( object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ClearBackground( $color ); }

/// Setup canvas (framebuffer) to start drawing
// void BeginDrawing(void);
function RL_BeginDrawing(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->BeginDrawing(  ); }

/// End canvas drawing and swap buffers (double buffering)
// void EndDrawing(void);
function RL_EndDrawing(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->EndDrawing(  ); }

/// Begin 2D mode with custom camera (2D)
// void BeginMode2D(Camera2D camera);
function RL_BeginMode2D( object $camera ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->BeginMode2D( $camera ); }

/// Ends 2D mode with custom camera
// void EndMode2D(void);
function RL_EndMode2D(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->EndMode2D(  ); }

/// Begin 3D mode with custom camera (3D)
// void BeginMode3D(Camera3D camera);
function RL_BeginMode3D( object $camera ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->BeginMode3D( $camera ); }

/// Ends 3D mode and returns to default 2D orthographic mode
// void EndMode3D(void);
function RL_EndMode3D(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->EndMode3D(  ); }

/// Begin drawing to render texture
// void BeginTextureMode(RenderTexture2D target);
function RL_BeginTextureMode( object $target ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->BeginTextureMode( $target ); }

/// Ends drawing to render texture
// void EndTextureMode(void);
function RL_EndTextureMode(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->EndTextureMode(  ); }

/// Begin custom shader drawing
// void BeginShaderMode(Shader shader);
function RL_BeginShaderMode( object $shader ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->BeginShaderMode( $shader ); }

/// End custom shader drawing (use default shader)
// void EndShaderMode(void);
function RL_EndShaderMode(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->EndShaderMode(  ); }

/// Begin blending mode (alpha, additive, multiplied, subtract, custom)
// void BeginBlendMode(int mode);
function RL_BeginBlendMode( int $mode ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->BeginBlendMode( $mode ); }

/// End blending mode (reset to default: alpha blending)
// void EndBlendMode(void);
function RL_EndBlendMode(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->EndBlendMode(  ); }

/// Begin scissor mode (define screen area for following drawing)
// void BeginScissorMode(int x , int y , int width , int height);
function RL_BeginScissorMode( int $x , int $y , int $width , int $height ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->BeginScissorMode( $x , $y , $width , $height ); }

/// End scissor mode
// void EndScissorMode(void);
function RL_EndScissorMode(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->EndScissorMode(  ); }

/// Begin stereo rendering (requires VR simulator)
// void BeginVrStereoMode(VrStereoConfig config);
function RL_BeginVrStereoMode( object $config ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->BeginVrStereoMode( $config ); }

/// End stereo rendering (requires VR simulator)
// void EndVrStereoMode(void);
function RL_EndVrStereoMode(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->EndVrStereoMode(  ); }

/// Load VR stereo config for VR simulator device parameters
// VrStereoConfig LoadVrStereoConfig(VrDeviceInfo device);
function RL_LoadVrStereoConfig( object $device ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadVrStereoConfig( $device ); }

/// Unload VR stereo config
// void UnloadVrStereoConfig(VrStereoConfig config);
function RL_UnloadVrStereoConfig( object $config ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadVrStereoConfig( $config ); }

/// Load shader from files and bind default locations
// Shader LoadShader(const char* vsFileName , const char* fsFileName);
function RL_LoadShader( string $vsFileName , string $fsFileName ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadShader( $vsFileName , $fsFileName ); }

/// Load shader from code strings and bind default locations
// Shader LoadShaderFromMemory(const char* vsCode , const char* fsCode);
function RL_LoadShaderFromMemory( string $vsCode , string $fsCode ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadShaderFromMemory( $vsCode , $fsCode ); }

/// Check if a shader is ready
// bool IsShaderReady(Shader shader);
function RL_IsShaderReady( object $shader ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsShaderReady( $shader ); }

/// Get shader uniform location
// int GetShaderLocation(Shader shader , const char* uniformName);
function RL_GetShaderLocation( object $shader , string $uniformName ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetShaderLocation( $shader , $uniformName ); }

/// Get shader attribute location
// int GetShaderLocationAttrib(Shader shader , const char* attribName);
function RL_GetShaderLocationAttrib( object $shader , string $attribName ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetShaderLocationAttrib( $shader , $attribName ); }

/// Set shader uniform value
// void SetShaderValue(Shader shader , int locIndex , const void* value , int uniformType);
function RL_SetShaderValue( object $shader , int $locIndex , object $value , int $uniformType ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetShaderValue( $shader , $locIndex , $value , $uniformType ); }

/// Set shader uniform value vector
// void SetShaderValueV(Shader shader , int locIndex , const void* value , int uniformType , int count);
function RL_SetShaderValueV( object $shader , int $locIndex , object $value , int $uniformType , int $count ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetShaderValueV( $shader , $locIndex , $value , $uniformType , $count ); }

/// Set shader uniform value (matrix 4x4)
// void SetShaderValueMatrix(Shader shader , int locIndex , Matrix mat);
function RL_SetShaderValueMatrix( object $shader , int $locIndex , object $mat ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetShaderValueMatrix( $shader , $locIndex , $mat ); }

/// Set shader uniform value for texture (sampler2d)
// void SetShaderValueTexture(Shader shader , int locIndex , Texture2D texture);
function RL_SetShaderValueTexture( object $shader , int $locIndex , object $texture ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetShaderValueTexture( $shader , $locIndex , $texture ); }

/// Unload shader from GPU memory (VRAM)
// void UnloadShader(Shader shader);
function RL_UnloadShader( object $shader ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadShader( $shader ); }

/// Get a ray trace from mouse position
// Ray GetMouseRay(Vector2 mousePosition , Camera camera);
function RL_GetMouseRay( object $mousePosition , object $camera ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMouseRay( $mousePosition , $camera ); }

/// Get camera transform matrix (view matrix)
// Matrix GetCameraMatrix(Camera camera);
function RL_GetCameraMatrix( object $camera ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCameraMatrix( $camera ); }

/// Get camera 2d transform matrix
// Matrix GetCameraMatrix2D(Camera2D camera);
function RL_GetCameraMatrix2D( object $camera ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCameraMatrix2D( $camera ); }

/// Get the screen space position for a 3d world space position
// Vector2 GetWorldToScreen(Vector3 position , Camera camera);
function RL_GetWorldToScreen( object $position , object $camera ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetWorldToScreen( $position , $camera ); }

/// Get the world space position for a 2d camera screen space position
// Vector2 GetScreenToWorld2D(Vector2 position , Camera2D camera);
function RL_GetScreenToWorld2D( object $position , object $camera ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetScreenToWorld2D( $position , $camera ); }

/// Get size position for a 3d world space position
// Vector2 GetWorldToScreenEx(Vector3 position , Camera camera , int width , int height);
function RL_GetWorldToScreenEx( object $position , object $camera , int $width , int $height ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetWorldToScreenEx( $position , $camera , $width , $height ); }

/// Get the screen space position for a 2d camera world space position
// Vector2 GetWorldToScreen2D(Vector2 position , Camera2D camera);
function RL_GetWorldToScreen2D( object $position , object $camera ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetWorldToScreen2D( $position , $camera ); }

/// Set target FPS (maximum)
// void SetTargetFPS(int fps);
function RL_SetTargetFPS( int $fps ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetTargetFPS( $fps ); }

/// Get current FPS
// int GetFPS(void);
function RL_GetFPS(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetFPS(  ); }

/// Get time in seconds for last frame drawn (delta time)
// float GetFrameTime(void);
function RL_GetFrameTime(  ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GetFrameTime(  ); }

/// Get elapsed time in seconds since InitWindow()
// double GetTime(void);
function RL_GetTime(  ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GetTime(  ); }

/// Get a random value between min and max (both included)
// int GetRandomValue(int min , int max);
function RL_GetRandomValue( int $min , int $max ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetRandomValue( $min , $max ); }

/// Set the seed for the random number generator
// void SetRandomSeed(unsigned int seed);
function RL_SetRandomSeed( int $seed ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetRandomSeed( $seed ); }

/// Takes a screenshot of current screen (filename extension defines format)
// void TakeScreenshot(const char* fileName);
function RL_TakeScreenshot( string $fileName ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->TakeScreenshot( $fileName ); }

/// Setup init configuration flags (view FLAGS)
// void SetConfigFlags(unsigned int flags);
function RL_SetConfigFlags( int $flags ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetConfigFlags( $flags ); }

/// Show trace log messages (LOG_DEBUG, LOG_INFO, LOG_WARNING, LOG_ERROR...)
// void TraceLog(int logLevel , const char* text , ...);
function RL_TraceLog( int $logLevel , string $text , ...$_ ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->TraceLog( $logLevel , $text , ...$_ ); }

/// Set the current threshold (minimum) log level
// void SetTraceLogLevel(int logLevel);
function RL_SetTraceLogLevel( int $logLevel ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetTraceLogLevel( $logLevel ); }

/// Internal memory allocator
// void* MemAlloc(unsigned int size);
function RL_MemAlloc( int $size ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MemAlloc( $size ); }

/// Internal memory reallocator
// void* MemRealloc(void* ptr , unsigned int size);
function RL_MemRealloc( object $ptr , int $size ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MemRealloc( $ptr , $size ); }

/// Internal memory free
// void MemFree(void* ptr);
function RL_MemFree( object $ptr ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->MemFree( $ptr ); }

/// Open URL with default system browser (if available)
// void OpenURL(const char* url);
function RL_OpenURL( string $url ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->OpenURL( $url ); }

/// Set custom trace log
// void SetTraceLogCallback(TraceLogCallback callback);
//XXX function RL_SetTraceLogCallback( TraceLogCallback callback ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetTraceLogCallback(  ); }

/// Set custom file binary data loader
// void SetLoadFileDataCallback(LoadFileDataCallback callback);
//XXX function RL_SetLoadFileDataCallback( LoadFileDataCallback callback ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetLoadFileDataCallback(  ); }

/// Set custom file binary data saver
// void SetSaveFileDataCallback(SaveFileDataCallback callback);
//XXX function RL_SetSaveFileDataCallback( SaveFileDataCallback callback ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetSaveFileDataCallback(  ); }

/// Set custom file text data loader
// void SetLoadFileTextCallback(LoadFileTextCallback callback);
//XXX function RL_SetLoadFileTextCallback( LoadFileTextCallback callback ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetLoadFileTextCallback(  ); }

/// Set custom file text data saver
// void SetSaveFileTextCallback(SaveFileTextCallback callback);
//XXX function RL_SetSaveFileTextCallback( SaveFileTextCallback callback ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetSaveFileTextCallback(  ); }

/// Load file data as byte array (read)
// unsigned char* LoadFileData(const char* fileName , unsigned int* bytesRead);
//XXX function RL_LoadFileData( string $fileName , int /*ref:int*/&$bytesRead ) : string { global $RAYLIB_FFI; static $__c_ref__bytesRead = null ; $__c_ref__bytesRead ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->LoadFileData( $fileName , FFI::addr($__c_ref__bytesRead) ); $bytesRead = $__c_ref__bytesRead->cdata ; return $__result__; }

/// Unload file data allocated by LoadFileData()
// void UnloadFileData(unsigned char* data);
//XXX function RL_UnloadFileData( string $data ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadFileData( $data ); }

/// Save data to file from byte array (write), returns true on success
// bool SaveFileData(const char* fileName , void* data , unsigned int bytesToWrite);
function RL_SaveFileData( string $fileName , object $data , int $bytesToWrite ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->SaveFileData( $fileName , $data , $bytesToWrite ); }

/// Export data to code (.h), returns true on success
// bool ExportDataAsCode(const unsigned char* data , unsigned int size , const char* fileName);
function RL_ExportDataAsCode( string $data , int $size , string $fileName ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->ExportDataAsCode( $data , $size , $fileName ); }

/// Load text data from file (read), returns a '\0' terminated string
// char* LoadFileText(const char* fileName);
function RL_LoadFileText( string $fileName ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadFileText( $fileName ); }

/// Unload file text data allocated by LoadFileText()
// void UnloadFileText(char* text);
function RL_UnloadFileText( string $text ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadFileText( $text ); }

/// Save text data to file (write), string must be '\0' terminated, returns true on success
// bool SaveFileText(const char* fileName , char* text);
function RL_SaveFileText( string $fileName , string $text ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->SaveFileText( $fileName , $text ); }

/// Check if file exists
// bool FileExists(const char* fileName);
function RL_FileExists( string $fileName ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->FileExists( $fileName ); }

/// Check if a directory path exists
// bool DirectoryExists(const char* dirPath);
function RL_DirectoryExists( string $dirPath ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->DirectoryExists( $dirPath ); }

/// Check file extension (including point: .png, .wav)
// bool IsFileExtension(const char* fileName , const char* ext);
function RL_IsFileExtension( string $fileName , string $ext ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsFileExtension( $fileName , $ext ); }

/// Get file length in bytes (NOTE: GetFileSize() conflicts with windows.h)
// int GetFileLength(const char* fileName);
function RL_GetFileLength( string $fileName ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetFileLength( $fileName ); }

/// Get pointer to extension for a filename string (includes dot: '.png')
// const char* GetFileExtension(const char* fileName);
function RL_GetFileExtension( string $fileName ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GetFileExtension( $fileName ); }

/// Get pointer to filename for a path string
// const char* GetFileName(const char* filePath);
function RL_GetFileName( string $filePath ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GetFileName( $filePath ); }

/// Get filename string without extension (uses static string)
// const char* GetFileNameWithoutExt(const char* filePath);
function RL_GetFileNameWithoutExt( string $filePath ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GetFileNameWithoutExt( $filePath ); }

/// Get full path for a given fileName with path (uses static string)
// const char* GetDirectoryPath(const char* filePath);
function RL_GetDirectoryPath( string $filePath ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GetDirectoryPath( $filePath ); }

/// Get previous directory path for a given path (uses static string)
// const char* GetPrevDirectoryPath(const char* dirPath);
function RL_GetPrevDirectoryPath( string $dirPath ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GetPrevDirectoryPath( $dirPath ); }

/// Get current working directory (uses static string)
// const char* GetWorkingDirectory(void);
function RL_GetWorkingDirectory(  ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GetWorkingDirectory(  ); }

/// Get the directory if the running application (uses static string)
// const char* GetApplicationDirectory(void);
function RL_GetApplicationDirectory(  ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GetApplicationDirectory(  ); }

/// Change working directory, return true on success
// bool ChangeDirectory(const char* dir);
function RL_ChangeDirectory( string $dir ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->ChangeDirectory( $dir ); }

/// Check if a given path is a file or a directory
// bool IsPathFile(const char* path);
function RL_IsPathFile( string $path ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsPathFile( $path ); }

/// Load directory filepaths
// FilePathList LoadDirectoryFiles(const char* dirPath);
function RL_LoadDirectoryFiles( string $dirPath ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadDirectoryFiles( $dirPath ); }

/// Load directory filepaths with extension filtering and recursive directory scan
// FilePathList LoadDirectoryFilesEx(const char* basePath , const char* filter , bool scanSubdirs);
function RL_LoadDirectoryFilesEx( string $basePath , string $filter , bool $scanSubdirs ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadDirectoryFilesEx( $basePath , $filter , $scanSubdirs ); }

/// Unload filepaths
// void UnloadDirectoryFiles(FilePathList files);
function RL_UnloadDirectoryFiles( object $files ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadDirectoryFiles( $files ); }

/// Check if a file has been dropped into window
// bool IsFileDropped(void);
function RL_IsFileDropped(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsFileDropped(  ); }

/// Load dropped filepaths
// FilePathList LoadDroppedFiles(void);
function RL_LoadDroppedFiles(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadDroppedFiles(  ); }

/// Unload dropped filepaths
// void UnloadDroppedFiles(FilePathList files);
function RL_UnloadDroppedFiles( object $files ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadDroppedFiles( $files ); }

/// Get file modification time (last write time)
// long GetFileModTime(const char* fileName);
function RL_GetFileModTime( string $fileName ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetFileModTime( $fileName ); }

/// Compress data (DEFLATE algorithm), memory must be MemFree()
// unsigned char* CompressData(const unsigned char* data , int dataSize , int* compDataSize);
function RL_CompressData( string $data , int $dataSize , int /*ref:int*/&$compDataSize ) : string { global $RAYLIB_FFI; static $__c_ref__compDataSize = null ; $__c_ref__compDataSize ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->CompressData( $data , $dataSize , FFI::addr($__c_ref__compDataSize) ); $compDataSize = $__c_ref__compDataSize->cdata ; return $__result__; }

/// Decompress data (DEFLATE algorithm), memory must be MemFree()
// unsigned char* DecompressData(const unsigned char* compData , int compDataSize , int* dataSize);
function RL_DecompressData( string $compData , int $compDataSize , int /*ref:int*/&$dataSize ) : string { global $RAYLIB_FFI; static $__c_ref__dataSize = null ; $__c_ref__dataSize ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->DecompressData( $compData , $compDataSize , FFI::addr($__c_ref__dataSize) ); $dataSize = $__c_ref__dataSize->cdata ; return $__result__; }

/// Encode data to Base64 string, memory must be MemFree()
// char* EncodeDataBase64(const unsigned char* data , int dataSize , int* outputSize);
function RL_EncodeDataBase64( string $data , int $dataSize , int /*ref:int*/&$outputSize ) : string { global $RAYLIB_FFI; static $__c_ref__outputSize = null ; $__c_ref__outputSize ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->EncodeDataBase64( $data , $dataSize , FFI::addr($__c_ref__outputSize) ); $outputSize = $__c_ref__outputSize->cdata ; return $__result__; }

/// Decode Base64 string data, memory must be MemFree()
// unsigned char* DecodeDataBase64(const unsigned char* data , int* outputSize);
function RL_DecodeDataBase64( string $data , int /*ref:int*/&$outputSize ) : string { global $RAYLIB_FFI; static $__c_ref__outputSize = null ; $__c_ref__outputSize ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->DecodeDataBase64( $data , FFI::addr($__c_ref__outputSize) ); $outputSize = $__c_ref__outputSize->cdata ; return $__result__; }

/// Check if a key has been pressed once
// bool IsKeyPressed(int key);
function RL_IsKeyPressed( int $key ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsKeyPressed( $key ); }

/// Check if a key is being pressed
// bool IsKeyDown(int key);
function RL_IsKeyDown( int $key ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsKeyDown( $key ); }

/// Check if a key has been released once
// bool IsKeyReleased(int key);
function RL_IsKeyReleased( int $key ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsKeyReleased( $key ); }

/// Check if a key is NOT being pressed
// bool IsKeyUp(int key);
function RL_IsKeyUp( int $key ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsKeyUp( $key ); }

/// Set a custom key to exit program (default is ESC)
// void SetExitKey(int key);
function RL_SetExitKey( int $key ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetExitKey( $key ); }

/// Get key pressed (keycode), call it multiple times for keys queued, returns 0 when the queue is empty
// int GetKeyPressed(void);
function RL_GetKeyPressed(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetKeyPressed(  ); }

/// Get char pressed (unicode), call it multiple times for chars queued, returns 0 when the queue is empty
// int GetCharPressed(void);
function RL_GetCharPressed(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCharPressed(  ); }

/// Check if a gamepad is available
// bool IsGamepadAvailable(int gamepad);
function RL_IsGamepadAvailable( int $gamepad ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsGamepadAvailable( $gamepad ); }

/// Get gamepad internal name id
// const char* GetGamepadName(int gamepad);
function RL_GetGamepadName( int $gamepad ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGamepadName( $gamepad ); }

/// Check if a gamepad button has been pressed once
// bool IsGamepadButtonPressed(int gamepad , int button);
function RL_IsGamepadButtonPressed( int $gamepad , int $button ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsGamepadButtonPressed( $gamepad , $button ); }

/// Check if a gamepad button is being pressed
// bool IsGamepadButtonDown(int gamepad , int button);
function RL_IsGamepadButtonDown( int $gamepad , int $button ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsGamepadButtonDown( $gamepad , $button ); }

/// Check if a gamepad button has been released once
// bool IsGamepadButtonReleased(int gamepad , int button);
function RL_IsGamepadButtonReleased( int $gamepad , int $button ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsGamepadButtonReleased( $gamepad , $button ); }

/// Check if a gamepad button is NOT being pressed
// bool IsGamepadButtonUp(int gamepad , int button);
function RL_IsGamepadButtonUp( int $gamepad , int $button ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsGamepadButtonUp( $gamepad , $button ); }

/// Get the last gamepad button pressed
// int GetGamepadButtonPressed(void);
function RL_GetGamepadButtonPressed(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGamepadButtonPressed(  ); }

/// Get gamepad axis count for a gamepad
// int GetGamepadAxisCount(int gamepad);
function RL_GetGamepadAxisCount( int $gamepad ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGamepadAxisCount( $gamepad ); }

/// Get axis movement value for a gamepad axis
// float GetGamepadAxisMovement(int gamepad , int axis);
function RL_GetGamepadAxisMovement( int $gamepad , int $axis ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGamepadAxisMovement( $gamepad , $axis ); }

/// Set internal gamepad mappings (SDL_GameControllerDB)
// int SetGamepadMappings(const char* mappings);
function RL_SetGamepadMappings( string $mappings ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->SetGamepadMappings( $mappings ); }

/// Check if a mouse button has been pressed once
// bool IsMouseButtonPressed(int button);
function RL_IsMouseButtonPressed( int $button ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsMouseButtonPressed( $button ); }

/// Check if a mouse button is being pressed
// bool IsMouseButtonDown(int button);
function RL_IsMouseButtonDown( int $button ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsMouseButtonDown( $button ); }

/// Check if a mouse button has been released once
// bool IsMouseButtonReleased(int button);
function RL_IsMouseButtonReleased( int $button ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsMouseButtonReleased( $button ); }

/// Check if a mouse button is NOT being pressed
// bool IsMouseButtonUp(int button);
function RL_IsMouseButtonUp( int $button ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsMouseButtonUp( $button ); }

/// Get mouse position X
// int GetMouseX(void);
function RL_GetMouseX(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMouseX(  ); }

/// Get mouse position Y
// int GetMouseY(void);
function RL_GetMouseY(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMouseY(  ); }

/// Get mouse position XY
// Vector2 GetMousePosition(void);
function RL_GetMousePosition(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMousePosition(  ); }

/// Get mouse delta between frames
// Vector2 GetMouseDelta(void);
function RL_GetMouseDelta(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMouseDelta(  ); }

/// Set mouse position XY
// void SetMousePosition(int x , int y);
function RL_SetMousePosition( int $x , int $y ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetMousePosition( $x , $y ); }

/// Set mouse offset
// void SetMouseOffset(int offsetX , int offsetY);
function RL_SetMouseOffset( int $offsetX , int $offsetY ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetMouseOffset( $offsetX , $offsetY ); }

/// Set mouse scaling
// void SetMouseScale(float scaleX , float scaleY);
function RL_SetMouseScale( float $scaleX , float $scaleY ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetMouseScale( $scaleX , $scaleY ); }

/// Get mouse wheel movement for X or Y, whichever is larger
// float GetMouseWheelMove(void);
function RL_GetMouseWheelMove(  ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMouseWheelMove(  ); }

/// Get mouse wheel movement for both X and Y
// Vector2 GetMouseWheelMoveV(void);
function RL_GetMouseWheelMoveV(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMouseWheelMoveV(  ); }

/// Set mouse cursor
// void SetMouseCursor(int cursor);
function RL_SetMouseCursor( int $cursor ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetMouseCursor( $cursor ); }

/// Get touch position X for touch point 0 (relative to screen size)
// int GetTouchX(void);
function RL_GetTouchX(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetTouchX(  ); }

/// Get touch position Y for touch point 0 (relative to screen size)
// int GetTouchY(void);
function RL_GetTouchY(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetTouchY(  ); }

/// Get touch position XY for a touch point index (relative to screen size)
// Vector2 GetTouchPosition(int index);
function RL_GetTouchPosition( int $index ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetTouchPosition( $index ); }

/// Get touch point identifier for given index
// int GetTouchPointId(int index);
function RL_GetTouchPointId( int $index ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetTouchPointId( $index ); }

/// Get number of touch points
// int GetTouchPointCount(void);
function RL_GetTouchPointCount(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetTouchPointCount(  ); }

/// Enable a set of gestures using flags
// void SetGesturesEnabled(unsigned int flags);
function RL_SetGesturesEnabled( int $flags ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetGesturesEnabled( $flags ); }

/// Check if a gesture have been detected
// bool IsGestureDetected(int gesture);
function RL_IsGestureDetected( int $gesture ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsGestureDetected( $gesture ); }

/// Get latest detected gesture
// int GetGestureDetected(void);
function RL_GetGestureDetected(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGestureDetected(  ); }

/// Get gesture hold time in milliseconds
// float GetGestureHoldDuration(void);
function RL_GetGestureHoldDuration(  ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGestureHoldDuration(  ); }

/// Get gesture drag vector
// Vector2 GetGestureDragVector(void);
function RL_GetGestureDragVector(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGestureDragVector(  ); }

/// Get gesture drag angle
// float GetGestureDragAngle(void);
function RL_GetGestureDragAngle(  ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGestureDragAngle(  ); }

/// Get gesture pinch delta
// Vector2 GetGesturePinchVector(void);
function RL_GetGesturePinchVector(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGesturePinchVector(  ); }

/// Get gesture pinch angle
// float GetGesturePinchAngle(void);
function RL_GetGesturePinchAngle(  ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGesturePinchAngle(  ); }

/// Set texture and rectangle to be used on shapes drawing
// void SetShapesTexture(Texture2D texture , Rectangle source);
function RL_SetShapesTexture( object $texture , object $source ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetShapesTexture( $texture , $source ); }

/// Draw a pixel
// void DrawPixel(int posX , int posY , Color color);
function RL_DrawPixel( int $posX , int $posY , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawPixel( $posX , $posY , $color ); }

/// Draw a pixel (Vector version)
// void DrawPixelV(Vector2 position , Color color);
function RL_DrawPixelV( object $position , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawPixelV( $position , $color ); }

/// Draw a line
// void DrawLine(int startPosX , int startPosY , int endPosX , int endPosY , Color color);
function RL_DrawLine( int $startPosX , int $startPosY , int $endPosX , int $endPosY , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawLine( $startPosX , $startPosY , $endPosX , $endPosY , $color ); }

/// Draw a line (Vector version)
// void DrawLineV(Vector2 startPos , Vector2 endPos , Color color);
function RL_DrawLineV( object $startPos , object $endPos , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawLineV( $startPos , $endPos , $color ); }

/// Draw a line defining thickness
// void DrawLineEx(Vector2 startPos , Vector2 endPos , float thick , Color color);
function RL_DrawLineEx( object $startPos , object $endPos , float $thick , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawLineEx( $startPos , $endPos , $thick , $color ); }

/// Draw a line using cubic-bezier curves in-out
// void DrawLineBezier(Vector2 startPos , Vector2 endPos , float thick , Color color);
function RL_DrawLineBezier( object $startPos , object $endPos , float $thick , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawLineBezier( $startPos , $endPos , $thick , $color ); }

/// Draw line using quadratic bezier curves with a control point
// void DrawLineBezierQuad(Vector2 startPos , Vector2 endPos , Vector2 controlPos , float thick , Color color);
function RL_DrawLineBezierQuad( object $startPos , object $endPos , object $controlPos , float $thick , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawLineBezierQuad( $startPos , $endPos , $controlPos , $thick , $color ); }

/// Draw line using cubic bezier curves with 2 control points
// void DrawLineBezierCubic(Vector2 startPos , Vector2 endPos , Vector2 startControlPos , Vector2 endControlPos , float thick , Color color);
function RL_DrawLineBezierCubic( object $startPos , object $endPos , object $startControlPos , object $endControlPos , float $thick , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawLineBezierCubic( $startPos , $endPos , $startControlPos , $endControlPos , $thick , $color ); }

/// Draw lines sequence
// void DrawLineStrip(Vector2* points , int pointCount , Color color);
function RL_DrawLineStrip( object $points , int $pointCount , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawLineStrip( $points , $pointCount , $color ); }

/// Draw a color-filled circle
// void DrawCircle(int centerX , int centerY , float radius , Color color);
function RL_DrawCircle( int $centerX , int $centerY , float $radius , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCircle( $centerX , $centerY , $radius , $color ); }

/// Draw a piece of a circle
// void DrawCircleSector(Vector2 center , float radius , float startAngle , float endAngle , int segments , Color color);
function RL_DrawCircleSector( object $center , float $radius , float $startAngle , float $endAngle , int $segments , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCircleSector( $center , $radius , $startAngle , $endAngle , $segments , $color ); }

/// Draw circle sector outline
// void DrawCircleSectorLines(Vector2 center , float radius , float startAngle , float endAngle , int segments , Color color);
function RL_DrawCircleSectorLines( object $center , float $radius , float $startAngle , float $endAngle , int $segments , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCircleSectorLines( $center , $radius , $startAngle , $endAngle , $segments , $color ); }

/// Draw a gradient-filled circle
// void DrawCircleGradient(int centerX , int centerY , float radius , Color color1 , Color color2);
function RL_DrawCircleGradient( int $centerX , int $centerY , float $radius , object $color1 , object $color2 ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCircleGradient( $centerX , $centerY , $radius , $color1 , $color2 ); }

/// Draw a color-filled circle (Vector version)
// void DrawCircleV(Vector2 center , float radius , Color color);
function RL_DrawCircleV( object $center , float $radius , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCircleV( $center , $radius , $color ); }

/// Draw circle outline
// void DrawCircleLines(int centerX , int centerY , float radius , Color color);
function RL_DrawCircleLines( int $centerX , int $centerY , float $radius , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCircleLines( $centerX , $centerY , $radius , $color ); }

/// Draw ellipse
// void DrawEllipse(int centerX , int centerY , float radiusH , float radiusV , Color color);
function RL_DrawEllipse( int $centerX , int $centerY , float $radiusH , float $radiusV , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawEllipse( $centerX , $centerY , $radiusH , $radiusV , $color ); }

/// Draw ellipse outline
// void DrawEllipseLines(int centerX , int centerY , float radiusH , float radiusV , Color color);
function RL_DrawEllipseLines( int $centerX , int $centerY , float $radiusH , float $radiusV , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawEllipseLines( $centerX , $centerY , $radiusH , $radiusV , $color ); }

/// Draw ring
// void DrawRing(Vector2 center , float innerRadius , float outerRadius , float startAngle , float endAngle , int segments , Color color);
function RL_DrawRing( object $center , float $innerRadius , float $outerRadius , float $startAngle , float $endAngle , int $segments , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRing( $center , $innerRadius , $outerRadius , $startAngle , $endAngle , $segments , $color ); }

/// Draw ring outline
// void DrawRingLines(Vector2 center , float innerRadius , float outerRadius , float startAngle , float endAngle , int segments , Color color);
function RL_DrawRingLines( object $center , float $innerRadius , float $outerRadius , float $startAngle , float $endAngle , int $segments , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRingLines( $center , $innerRadius , $outerRadius , $startAngle , $endAngle , $segments , $color ); }

/// Draw a color-filled rectangle
// void DrawRectangle(int posX , int posY , int width , int height , Color color);
function RL_DrawRectangle( int $posX , int $posY , int $width , int $height , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectangle( $posX , $posY , $width , $height , $color ); }

/// Draw a color-filled rectangle (Vector version)
// void DrawRectangleV(Vector2 position , Vector2 size , Color color);
function RL_DrawRectangleV( object $position , object $size , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectangleV( $position , $size , $color ); }

/// Draw a color-filled rectangle
// void DrawRectangleRec(Rectangle rec , Color color);
function RL_DrawRectangleRec( object $rec , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectangleRec( $rec , $color ); }

/// Draw a color-filled rectangle with pro parameters
// void DrawRectanglePro(Rectangle rec , Vector2 origin , float rotation , Color color);
function RL_DrawRectanglePro( object $rec , object $origin , float $rotation , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectanglePro( $rec , $origin , $rotation , $color ); }

/// Draw a vertical-gradient-filled rectangle
// void DrawRectangleGradientV(int posX , int posY , int width , int height , Color color1 , Color color2);
function RL_DrawRectangleGradientV( int $posX , int $posY , int $width , int $height , object $color1 , object $color2 ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectangleGradientV( $posX , $posY , $width , $height , $color1 , $color2 ); }

/// Draw a horizontal-gradient-filled rectangle
// void DrawRectangleGradientH(int posX , int posY , int width , int height , Color color1 , Color color2);
function RL_DrawRectangleGradientH( int $posX , int $posY , int $width , int $height , object $color1 , object $color2 ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectangleGradientH( $posX , $posY , $width , $height , $color1 , $color2 ); }

/// Draw a gradient-filled rectangle with custom vertex colors
// void DrawRectangleGradientEx(Rectangle rec , Color col1 , Color col2 , Color col3 , Color col4);
function RL_DrawRectangleGradientEx( object $rec , object $col1 , object $col2 , object $col3 , object $col4 ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectangleGradientEx( $rec , $col1 , $col2 , $col3 , $col4 ); }

/// Draw rectangle outline
// void DrawRectangleLines(int posX , int posY , int width , int height , Color color);
function RL_DrawRectangleLines( int $posX , int $posY , int $width , int $height , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectangleLines( $posX , $posY , $width , $height , $color ); }

/// Draw rectangle outline with extended parameters
// void DrawRectangleLinesEx(Rectangle rec , float lineThick , Color color);
function RL_DrawRectangleLinesEx( object $rec , float $lineThick , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectangleLinesEx( $rec , $lineThick , $color ); }

/// Draw rectangle with rounded edges
// void DrawRectangleRounded(Rectangle rec , float roundness , int segments , Color color);
function RL_DrawRectangleRounded( object $rec , float $roundness , int $segments , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectangleRounded( $rec , $roundness , $segments , $color ); }

/// Draw rectangle with rounded edges outline
// void DrawRectangleRoundedLines(Rectangle rec , float roundness , int segments , float lineThick , Color color);
function RL_DrawRectangleRoundedLines( object $rec , float $roundness , int $segments , float $lineThick , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRectangleRoundedLines( $rec , $roundness , $segments , $lineThick , $color ); }

/// Draw a color-filled triangle (vertex in counter-clockwise order!)
// void DrawTriangle(Vector2 v1 , Vector2 v2 , Vector2 v3 , Color color);
function RL_DrawTriangle( object $v1 , object $v2 , object $v3 , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTriangle( $v1 , $v2 , $v3 , $color ); }

/// Draw triangle outline (vertex in counter-clockwise order!)
// void DrawTriangleLines(Vector2 v1 , Vector2 v2 , Vector2 v3 , Color color);
function RL_DrawTriangleLines( object $v1 , object $v2 , object $v3 , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTriangleLines( $v1 , $v2 , $v3 , $color ); }

/// Draw a triangle fan defined by points (first vertex is the center)
// void DrawTriangleFan(Vector2* points , int pointCount , Color color);
function RL_DrawTriangleFan( object $points , int $pointCount , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTriangleFan( $points , $pointCount , $color ); }

/// Draw a triangle strip defined by points
// void DrawTriangleStrip(Vector2* points , int pointCount , Color color);
function RL_DrawTriangleStrip( object $points , int $pointCount , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTriangleStrip( $points , $pointCount , $color ); }

/// Draw a regular polygon (Vector version)
// void DrawPoly(Vector2 center , int sides , float radius , float rotation , Color color);
function RL_DrawPoly( object $center , int $sides , float $radius , float $rotation , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawPoly( $center , $sides , $radius , $rotation , $color ); }

/// Draw a polygon outline of n sides
// void DrawPolyLines(Vector2 center , int sides , float radius , float rotation , Color color);
function RL_DrawPolyLines( object $center , int $sides , float $radius , float $rotation , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawPolyLines( $center , $sides , $radius , $rotation , $color ); }

/// Draw a polygon outline of n sides with extended parameters
// void DrawPolyLinesEx(Vector2 center , int sides , float radius , float rotation , float lineThick , Color color);
function RL_DrawPolyLinesEx( object $center , int $sides , float $radius , float $rotation , float $lineThick , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawPolyLinesEx( $center , $sides , $radius , $rotation , $lineThick , $color ); }

/// Check collision between two rectangles
// bool CheckCollisionRecs(Rectangle rec1 , Rectangle rec2);
function RL_CheckCollisionRecs( object $rec1 , object $rec2 ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionRecs( $rec1 , $rec2 ); }

/// Check collision between two circles
// bool CheckCollisionCircles(Vector2 center1 , float radius1 , Vector2 center2 , float radius2);
function RL_CheckCollisionCircles( object $center1 , float $radius1 , object $center2 , float $radius2 ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionCircles( $center1 , $radius1 , $center2 , $radius2 ); }

/// Check collision between circle and rectangle
// bool CheckCollisionCircleRec(Vector2 center , float radius , Rectangle rec);
function RL_CheckCollisionCircleRec( object $center , float $radius , object $rec ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionCircleRec( $center , $radius , $rec ); }

/// Check if point is inside rectangle
// bool CheckCollisionPointRec(Vector2 point , Rectangle rec);
function RL_CheckCollisionPointRec( object $point , object $rec ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionPointRec( $point , $rec ); }

/// Check if point is inside circle
// bool CheckCollisionPointCircle(Vector2 point , Vector2 center , float radius);
function RL_CheckCollisionPointCircle( object $point , object $center , float $radius ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionPointCircle( $point , $center , $radius ); }

/// Check if point is inside a triangle
// bool CheckCollisionPointTriangle(Vector2 point , Vector2 p1 , Vector2 p2 , Vector2 p3);
function RL_CheckCollisionPointTriangle( object $point , object $p1 , object $p2 , object $p3 ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionPointTriangle( $point , $p1 , $p2 , $p3 ); }

/// Check if point is within a polygon described by array of vertices
// bool CheckCollisionPointPoly(Vector2 point , Vector2* points , int pointCount);
function RL_CheckCollisionPointPoly( object $point , object $points , int $pointCount ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionPointPoly( $point , $points , $pointCount ); }

/// Check the collision between two lines defined by two points each, returns collision point by reference
// bool CheckCollisionLines(Vector2 startPos1 , Vector2 endPos1 , Vector2 startPos2 , Vector2 endPos2 , Vector2* collisionPoint);
function RL_CheckCollisionLines( object $startPos1 , object $endPos1 , object $startPos2 , object $endPos2 , object $collisionPoint ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionLines( $startPos1 , $endPos1 , $startPos2 , $endPos2 , $collisionPoint ); }

/// Check if point belongs to line created between two points [p1] and [p2] with defined margin in pixels [threshold]
// bool CheckCollisionPointLine(Vector2 point , Vector2 p1 , Vector2 p2 , int threshold);
function RL_CheckCollisionPointLine( object $point , object $p1 , object $p2 , int $threshold ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionPointLine( $point , $p1 , $p2 , $threshold ); }

/// Get collision rectangle for two rectangles collision
// Rectangle GetCollisionRec(Rectangle rec1 , Rectangle rec2);
function RL_GetCollisionRec( object $rec1 , object $rec2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCollisionRec( $rec1 , $rec2 ); }

/// Load image from file into CPU memory (RAM)
// Image LoadImage(const char* fileName);
function RL_LoadImage( string $fileName ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadImage( $fileName ); }

/// Load image from RAW file data
// Image LoadImageRaw(const char* fileName , int width , int height , int format , int headerSize);
function RL_LoadImageRaw( string $fileName , int $width , int $height , int $format , int $headerSize ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadImageRaw( $fileName , $width , $height , $format , $headerSize ); }

/// Load image sequence from file (frames appended to image.data)
// Image LoadImageAnim(const char* fileName , int* frames);
function RL_LoadImageAnim( string $fileName , int /*ref:int*/&$frames ) : object { global $RAYLIB_FFI; static $__c_ref__frames = null ; $__c_ref__frames ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->LoadImageAnim( $fileName , FFI::addr($__c_ref__frames) ); $frames = $__c_ref__frames->cdata ; return $__result__; }

/// Load image from memory buffer, fileType refers to extension: i.e. '.png'
// Image LoadImageFromMemory(const char* fileType , const unsigned char* fileData , int dataSize);
function RL_LoadImageFromMemory( string $fileType , string $fileData , int $dataSize ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadImageFromMemory( $fileType , $fileData , $dataSize ); }

/// Load image from GPU texture data
// Image LoadImageFromTexture(Texture2D texture);
function RL_LoadImageFromTexture( object $texture ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadImageFromTexture( $texture ); }

/// Load image from screen buffer and (screenshot)
// Image LoadImageFromScreen(void);
function RL_LoadImageFromScreen(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadImageFromScreen(  ); }

/// Check if an image is ready
// bool IsImageReady(Image image);
function RL_IsImageReady( object $image ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsImageReady( $image ); }

/// Unload image from CPU memory (RAM)
// void UnloadImage(Image image);
function RL_UnloadImage( object $image ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadImage( $image ); }

/// Export image data to file, returns true on success
// bool ExportImage(Image image , const char* fileName);
function RL_ExportImage( object $image , string $fileName ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->ExportImage( $image , $fileName ); }

/// Export image as code file defining an array of bytes, returns true on success
// bool ExportImageAsCode(Image image , const char* fileName);
function RL_ExportImageAsCode( object $image , string $fileName ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->ExportImageAsCode( $image , $fileName ); }

/// Generate image: plain color
// Image GenImageColor(int width , int height , Color color);
function RL_GenImageColor( int $width , int $height , object $color ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenImageColor( $width , $height , $color ); }

/// Generate image: vertical gradient
// Image GenImageGradientV(int width , int height , Color top , Color bottom);
function RL_GenImageGradientV( int $width , int $height , object $top , object $bottom ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenImageGradientV( $width , $height , $top , $bottom ); }

/// Generate image: horizontal gradient
// Image GenImageGradientH(int width , int height , Color left , Color right);
function RL_GenImageGradientH( int $width , int $height , object $left , object $right ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenImageGradientH( $width , $height , $left , $right ); }

/// Generate image: radial gradient
// Image GenImageGradientRadial(int width , int height , float density , Color inner , Color outer);
function RL_GenImageGradientRadial( int $width , int $height , float $density , object $inner , object $outer ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenImageGradientRadial( $width , $height , $density , $inner , $outer ); }

/// Generate image: checked
// Image GenImageChecked(int width , int height , int checksX , int checksY , Color col1 , Color col2);
function RL_GenImageChecked( int $width , int $height , int $checksX , int $checksY , object $col1 , object $col2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenImageChecked( $width , $height , $checksX , $checksY , $col1 , $col2 ); }

/// Generate image: white noise
// Image GenImageWhiteNoise(int width , int height , float factor);
function RL_GenImageWhiteNoise( int $width , int $height , float $factor ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenImageWhiteNoise( $width , $height , $factor ); }

/// Generate image: perlin noise
// Image GenImagePerlinNoise(int width , int height , int offsetX , int offsetY , float scale);
function RL_GenImagePerlinNoise( int $width , int $height , int $offsetX , int $offsetY , float $scale ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenImagePerlinNoise( $width , $height , $offsetX , $offsetY , $scale ); }

/// Generate image: cellular algorithm, bigger tileSize means bigger cells
// Image GenImageCellular(int width , int height , int tileSize);
function RL_GenImageCellular( int $width , int $height , int $tileSize ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenImageCellular( $width , $height , $tileSize ); }

/// Generate image: grayscale image from text data
// Image GenImageText(int width , int height , const char* text);
function RL_GenImageText( int $width , int $height , string $text ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenImageText( $width , $height , $text ); }

/// Create an image duplicate (useful for transformations)
// Image ImageCopy(Image image);
function RL_ImageCopy( object $image ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ImageCopy( $image ); }

/// Create an image from another image piece
// Image ImageFromImage(Image image , Rectangle rec);
function RL_ImageFromImage( object $image , object $rec ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ImageFromImage( $image , $rec ); }

/// Create an image from text (default font)
// Image ImageText(const char* text , int fontSize , Color color);
function RL_ImageText( string $text , int $fontSize , object $color ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ImageText( $text , $fontSize , $color ); }

/// Create an image from text (custom sprite font)
// Image ImageTextEx(Font font , const char* text , float fontSize , float spacing , Color tint);
function RL_ImageTextEx( object $font , string $text , float $fontSize , float $spacing , object $tint ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ImageTextEx( $font , $text , $fontSize , $spacing , $tint ); }

/// Crop an image to a defined rectangle
// void ImageCrop(Image* image , Rectangle crop);
function RL_ImageCrop( object /*ref*/$image , object $crop ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageCrop( FFI::addr($image) , $crop ); }

/// Convert image data to desired format
// void ImageFormat(Image* image , int newFormat);
function RL_ImageFormat( object /*ref*/$image , int $newFormat ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageFormat( FFI::addr($image) , $newFormat ); }

/// Resize image (Nearest-Neighbor scaling algorithm)
// void ImageResizeNN(Image* image , int newWidth , int newHeight);
function RL_ImageResizeNN( object /*ref*/$image , int $newWidth , int $newHeight ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageResizeNN( FFI::addr($image) , $newWidth , $newHeight ); }

/// Resize image (Bicubic scaling algorithm)
// void ImageResize(Image* image , int newWidth , int newHeight);
function RL_ImageResize( object /*ref*/$image , int $newWidth , int $newHeight ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageResize( FFI::addr($image) , $newWidth , $newHeight ); }

/// Resize canvas and fill with color
// void ImageResizeCanvas(Image* image , int newWidth , int newHeight , int offsetX , int offsetY , Color fill);
function RL_ImageResizeCanvas( object /*ref*/$image , int $newWidth , int $newHeight , int $offsetX , int $offsetY , object $fill ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageResizeCanvas( FFI::addr($image) , $newWidth , $newHeight , $offsetX , $offsetY , $fill ); }

/// Convert image to POT (power-of-two)
// void ImageToPOT(Image* image , Color fill);
function RL_ImageToPOT( object /*ref*/$image , object $fill ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageToPOT( FFI::addr($image) , $fill ); }

/// Crop image depending on alpha value
// void ImageAlphaCrop(Image* image , float threshold);
function RL_ImageAlphaCrop( object /*ref*/$image , float $threshold ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageAlphaCrop( FFI::addr($image) , $threshold ); }

/// Clear alpha channel to desired color
// void ImageAlphaClear(Image* image , Color color , float threshold);
function RL_ImageAlphaClear( object /*ref*/$image , object $color , float $threshold ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageAlphaClear( FFI::addr($image) , $color , $threshold ); }

/// Apply alpha mask to image
// void ImageAlphaMask(Image* image , Image alphaMask);
function RL_ImageAlphaMask( object /*ref*/$image , object $alphaMask ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageAlphaMask( FFI::addr($image) , $alphaMask ); }

/// Premultiply alpha channel
// void ImageAlphaPremultiply(Image* image);
function RL_ImageAlphaPremultiply( object /*ref*/$image ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageAlphaPremultiply( FFI::addr($image) ); }

/// Apply Gaussian blur using a box blur approximation
// void ImageBlurGaussian(Image* image , int blurSize);
function RL_ImageBlurGaussian( object /*ref*/$image , int $blurSize ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageBlurGaussian( FFI::addr($image) , $blurSize ); }

/// Compute all mipmap levels for a provided image
// void ImageMipmaps(Image* image);
function RL_ImageMipmaps( object /*ref*/$image ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageMipmaps( FFI::addr($image) ); }

/// Dither image data to 16bpp or lower (Floyd-Steinberg dithering)
// void ImageDither(Image* image , int rBpp , int gBpp , int bBpp , int aBpp);
function RL_ImageDither( object /*ref*/$image , int $rBpp , int $gBpp , int $bBpp , int $aBpp ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDither( FFI::addr($image) , $rBpp , $gBpp , $bBpp , $aBpp ); }

/// Flip image vertically
// void ImageFlipVertical(Image* image);
function RL_ImageFlipVertical( object /*ref*/$image ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageFlipVertical( FFI::addr($image) ); }

/// Flip image horizontally
// void ImageFlipHorizontal(Image* image);
function RL_ImageFlipHorizontal( object /*ref*/$image ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageFlipHorizontal( FFI::addr($image) ); }

/// Rotate image clockwise 90deg
// void ImageRotateCW(Image* image);
function RL_ImageRotateCW( object /*ref*/$image ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageRotateCW( FFI::addr($image) ); }

/// Rotate image counter-clockwise 90deg
// void ImageRotateCCW(Image* image);
function RL_ImageRotateCCW( object /*ref*/$image ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageRotateCCW( FFI::addr($image) ); }

/// Modify image color: tint
// void ImageColorTint(Image* image , Color color);
function RL_ImageColorTint( object /*ref*/$image , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageColorTint( FFI::addr($image) , $color ); }

/// Modify image color: invert
// void ImageColorInvert(Image* image);
function RL_ImageColorInvert( object /*ref*/$image ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageColorInvert( FFI::addr($image) ); }

/// Modify image color: grayscale
// void ImageColorGrayscale(Image* image);
function RL_ImageColorGrayscale( object /*ref*/$image ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageColorGrayscale( FFI::addr($image) ); }

/// Modify image color: contrast (-100 to 100)
// void ImageColorContrast(Image* image , float contrast);
function RL_ImageColorContrast( object /*ref*/$image , float $contrast ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageColorContrast( FFI::addr($image) , $contrast ); }

/// Modify image color: brightness (-255 to 255)
// void ImageColorBrightness(Image* image , int brightness);
function RL_ImageColorBrightness( object /*ref*/$image , int $brightness ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageColorBrightness( FFI::addr($image) , $brightness ); }

/// Modify image color: replace color
// void ImageColorReplace(Image* image , Color color , Color replace);
function RL_ImageColorReplace( object /*ref*/$image , object $color , object $replace ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageColorReplace( FFI::addr($image) , $color , $replace ); }

/// Load color data from image as a Color array (RGBA - 32bit)
// Color* LoadImageColors(Image image);
function RL_LoadImageColors( object $image ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadImageColors( $image ); }

/// Load colors palette from image as a Color array (RGBA - 32bit)
// Color* LoadImagePalette(Image image , int maxPaletteSize , int* colorCount);
function RL_LoadImagePalette( object $image , int $maxPaletteSize , int /*ref:int*/&$colorCount ) : object { global $RAYLIB_FFI; static $__c_ref__colorCount = null ; $__c_ref__colorCount ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->LoadImagePalette( $image , $maxPaletteSize , FFI::addr($__c_ref__colorCount) ); $colorCount = $__c_ref__colorCount->cdata ; return $__result__; }

/// Unload color data loaded with LoadImageColors()
// void UnloadImageColors(Color* colors);
function RL_UnloadImageColors( object /*c_array*/$colors ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadImageColors( /*c_array*/$colors ); }

/// Unload colors palette loaded with LoadImagePalette()
// void UnloadImagePalette(Color* colors);
function RL_UnloadImagePalette( object /*c_array*/$colors ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadImagePalette( /*c_array*/$colors ); }

/// Get image alpha border rectangle
// Rectangle GetImageAlphaBorder(Image image , float threshold);
function RL_GetImageAlphaBorder( object $image , float $threshold ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetImageAlphaBorder( $image , $threshold ); }

/// Get image pixel color at (x, y) position
// Color GetImageColor(Image image , int x , int y);
function RL_GetImageColor( object $image , int $x , int $y ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetImageColor( $image , $x , $y ); }

/// Clear image background with given color
// void ImageClearBackground(Image* dst , Color color);
function RL_ImageClearBackground( object /*ref*/$dst , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageClearBackground( FFI::addr($dst) , $color ); }

/// Draw pixel within an image
// void ImageDrawPixel(Image* dst , int posX , int posY , Color color);
function RL_ImageDrawPixel( object /*ref*/$dst , int $posX , int $posY , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawPixel( FFI::addr($dst) , $posX , $posY , $color ); }

/// Draw pixel within an image (Vector version)
// void ImageDrawPixelV(Image* dst , Vector2 position , Color color);
function RL_ImageDrawPixelV( object /*ref*/$dst , object $position , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawPixelV( FFI::addr($dst) , $position , $color ); }

/// Draw line within an image
// void ImageDrawLine(Image* dst , int startPosX , int startPosY , int endPosX , int endPosY , Color color);
function RL_ImageDrawLine( object /*ref*/$dst , int $startPosX , int $startPosY , int $endPosX , int $endPosY , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawLine( FFI::addr($dst) , $startPosX , $startPosY , $endPosX , $endPosY , $color ); }

/// Draw line within an image (Vector version)
// void ImageDrawLineV(Image* dst , Vector2 start , Vector2 end , Color color);
function RL_ImageDrawLineV( object /*ref*/$dst , object $start , object $end , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawLineV( FFI::addr($dst) , $start , $end , $color ); }

/// Draw a filled circle within an image
// void ImageDrawCircle(Image* dst , int centerX , int centerY , int radius , Color color);
function RL_ImageDrawCircle( object /*ref*/$dst , int $centerX , int $centerY , int $radius , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawCircle( FFI::addr($dst) , $centerX , $centerY , $radius , $color ); }

/// Draw a filled circle within an image (Vector version)
// void ImageDrawCircleV(Image* dst , Vector2 center , int radius , Color color);
function RL_ImageDrawCircleV( object /*ref*/$dst , object $center , int $radius , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawCircleV( FFI::addr($dst) , $center , $radius , $color ); }

/// Draw circle outline within an image
// void ImageDrawCircleLines(Image* dst , int centerX , int centerY , int radius , Color color);
function RL_ImageDrawCircleLines( object /*ref*/$dst , int $centerX , int $centerY , int $radius , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawCircleLines( FFI::addr($dst) , $centerX , $centerY , $radius , $color ); }

/// Draw circle outline within an image (Vector version)
// void ImageDrawCircleLinesV(Image* dst , Vector2 center , int radius , Color color);
function RL_ImageDrawCircleLinesV( object /*ref*/$dst , object $center , int $radius , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawCircleLinesV( FFI::addr($dst) , $center , $radius , $color ); }

/// Draw rectangle within an image
// void ImageDrawRectangle(Image* dst , int posX , int posY , int width , int height , Color color);
function RL_ImageDrawRectangle( object /*ref*/$dst , int $posX , int $posY , int $width , int $height , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawRectangle( FFI::addr($dst) , $posX , $posY , $width , $height , $color ); }

/// Draw rectangle within an image (Vector version)
// void ImageDrawRectangleV(Image* dst , Vector2 position , Vector2 size , Color color);
function RL_ImageDrawRectangleV( object /*ref*/$dst , object $position , object $size , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawRectangleV( FFI::addr($dst) , $position , $size , $color ); }

/// Draw rectangle within an image
// void ImageDrawRectangleRec(Image* dst , Rectangle rec , Color color);
function RL_ImageDrawRectangleRec( object /*ref*/$dst , object $rec , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawRectangleRec( FFI::addr($dst) , $rec , $color ); }

/// Draw rectangle lines within an image
// void ImageDrawRectangleLines(Image* dst , Rectangle rec , int thick , Color color);
function RL_ImageDrawRectangleLines( object /*ref*/$dst , object $rec , int $thick , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawRectangleLines( FFI::addr($dst) , $rec , $thick , $color ); }

/// Draw a source image within a destination image (tint applied to source)
// void ImageDraw(Image* dst , Image src , Rectangle srcRec , Rectangle dstRec , Color tint);
function RL_ImageDraw( object /*ref*/$dst , object $src , object $srcRec , object $dstRec , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDraw( FFI::addr($dst) , $src , $srcRec , $dstRec , $tint ); }

/// Draw text (using default font) within an image (destination)
// void ImageDrawText(Image* dst , const char* text , int posX , int posY , int fontSize , Color color);
function RL_ImageDrawText( object /*ref*/$dst , string $text , int $posX , int $posY , int $fontSize , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawText( FFI::addr($dst) , $text , $posX , $posY , $fontSize , $color ); }

/// Draw text (custom sprite font) within an image (destination)
// void ImageDrawTextEx(Image* dst , Font font , const char* text , Vector2 position , float fontSize , float spacing , Color tint);
function RL_ImageDrawTextEx( object /*ref*/$dst , object $font , string $text , object $position , float $fontSize , float $spacing , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ImageDrawTextEx( FFI::addr($dst) , $font , $text , $position , $fontSize , $spacing , $tint ); }

/// Load texture from file into GPU memory (VRAM)
// Texture2D LoadTexture(const char* fileName);
function RL_LoadTexture( string $fileName ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadTexture( $fileName ); }

/// Load texture from image data
// Texture2D LoadTextureFromImage(Image image);
function RL_LoadTextureFromImage( object $image ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadTextureFromImage( $image ); }

/// Load cubemap from image, multiple image cubemap layouts supported
// TextureCubemap LoadTextureCubemap(Image image , int layout);
function RL_LoadTextureCubemap( object $image , int $layout ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadTextureCubemap( $image , $layout ); }

/// Load texture for rendering (framebuffer)
// RenderTexture2D LoadRenderTexture(int width , int height);
function RL_LoadRenderTexture( int $width , int $height ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadRenderTexture( $width , $height ); }

/// Check if a texture is ready
// bool IsTextureReady(Texture2D texture);
function RL_IsTextureReady( object $texture ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsTextureReady( $texture ); }

/// Unload texture from GPU memory (VRAM)
// void UnloadTexture(Texture2D texture);
function RL_UnloadTexture( object $texture ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadTexture( $texture ); }

/// Check if a render texture is ready
// bool IsRenderTextureReady(RenderTexture2D target);
function RL_IsRenderTextureReady( object $target ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsRenderTextureReady( $target ); }

/// Unload render texture from GPU memory (VRAM)
// void UnloadRenderTexture(RenderTexture2D target);
function RL_UnloadRenderTexture( object $target ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadRenderTexture( $target ); }

/// Update GPU texture with new data
// void UpdateTexture(Texture2D texture , const void* pixels);
function RL_UpdateTexture( object $texture , object $pixels ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UpdateTexture( $texture , $pixels ); }

/// Update GPU texture rectangle with new data
// void UpdateTextureRec(Texture2D texture , Rectangle rec , const void* pixels);
function RL_UpdateTextureRec( object $texture , object $rec , object $pixels ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UpdateTextureRec( $texture , $rec , $pixels ); }

/// Generate GPU mipmaps for a texture
// void GenTextureMipmaps(Texture2D* texture);
function RL_GenTextureMipmaps( object /*ref*/$texture ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GenTextureMipmaps( FFI::addr($texture) ); }

/// Set texture scaling filter mode
// void SetTextureFilter(Texture2D texture , int filter);
function RL_SetTextureFilter( object $texture , int $filter ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetTextureFilter( $texture , $filter ); }

/// Set texture wrapping mode
// void SetTextureWrap(Texture2D texture , int wrap);
function RL_SetTextureWrap( object $texture , int $wrap ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetTextureWrap( $texture , $wrap ); }

/// Draw a Texture2D
// void DrawTexture(Texture2D texture , int posX , int posY , Color tint);
function RL_DrawTexture( object $texture , int $posX , int $posY , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTexture( $texture , $posX , $posY , $tint ); }

/// Draw a Texture2D with position defined as Vector2
// void DrawTextureV(Texture2D texture , Vector2 position , Color tint);
function RL_DrawTextureV( object $texture , object $position , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTextureV( $texture , $position , $tint ); }

/// Draw a Texture2D with extended parameters
// void DrawTextureEx(Texture2D texture , Vector2 position , float rotation , float scale , Color tint);
function RL_DrawTextureEx( object $texture , object $position , float $rotation , float $scale , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTextureEx( $texture , $position , $rotation , $scale , $tint ); }

/// Draw a part of a texture defined by a rectangle
// void DrawTextureRec(Texture2D texture , Rectangle source , Vector2 position , Color tint);
function RL_DrawTextureRec( object $texture , object $source , object $position , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTextureRec( $texture , $source , $position , $tint ); }

/// Draw a part of a texture defined by a rectangle with 'pro' parameters
// void DrawTexturePro(Texture2D texture , Rectangle source , Rectangle dest , Vector2 origin , float rotation , Color tint);
function RL_DrawTexturePro( object $texture , object $source , object $dest , object $origin , float $rotation , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTexturePro( $texture , $source , $dest , $origin , $rotation , $tint ); }

/// Draws a texture (or part of it) that stretches or shrinks nicely
// void DrawTextureNPatch(Texture2D texture , NPatchInfo nPatchInfo , Rectangle dest , Vector2 origin , float rotation , Color tint);
function RL_DrawTextureNPatch( object $texture , object $nPatchInfo , object $dest , object $origin , float $rotation , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTextureNPatch( $texture , $nPatchInfo , $dest , $origin , $rotation , $tint ); }

/// Get color with alpha applied, alpha goes from 0.0f to 1.0f
// Color Fade(Color color , float alpha);
function RL_Fade( object $color , float $alpha ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Fade( $color , $alpha ); }

/// Get hexadecimal value for a Color
// int ColorToInt(Color color);
function RL_ColorToInt( object $color ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->ColorToInt( $color ); }

/// Get Color normalized as float [0..1]
// Vector4 ColorNormalize(Color color);
function RL_ColorNormalize( object $color ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ColorNormalize( $color ); }

/// Get Color from normalized values [0..1]
// Color ColorFromNormalized(Vector4 normalized);
function RL_ColorFromNormalized( object $normalized ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ColorFromNormalized( $normalized ); }

/// Get HSV values for a Color, hue [0..360], saturation/value [0..1]
// Vector3 ColorToHSV(Color color);
function RL_ColorToHSV( object $color ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ColorToHSV( $color ); }

/// Get a Color from HSV values, hue [0..360], saturation/value [0..1]
// Color ColorFromHSV(float hue , float saturation , float value);
function RL_ColorFromHSV( float $hue , float $saturation , float $value ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ColorFromHSV( $hue , $saturation , $value ); }

/// Get color multiplied with another color
// Color ColorTint(Color color , Color tint);
function RL_ColorTint( object $color , object $tint ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ColorTint( $color , $tint ); }

/// Get color with brightness correction, brightness factor goes from -1.0f to 1.0f
// Color ColorBrightness(Color color , float factor);
function RL_ColorBrightness( object $color , float $factor ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ColorBrightness( $color , $factor ); }

/// Get color with contrast correction, contrast values between -1.0f and 1.0f
// Color ColorContrast(Color color , float contrast);
function RL_ColorContrast( object $color , float $contrast ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ColorContrast( $color , $contrast ); }

/// Get color with alpha applied, alpha goes from 0.0f to 1.0f
// Color ColorAlpha(Color color , float alpha);
function RL_ColorAlpha( object $color , float $alpha ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ColorAlpha( $color , $alpha ); }

/// Get src alpha-blended into dst color with tint
// Color ColorAlphaBlend(Color dst , Color src , Color tint);
function RL_ColorAlphaBlend( object $dst , object $src , object $tint ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->ColorAlphaBlend( $dst , $src , $tint ); }

/// Get Color structure from hexadecimal value
// Color GetColor(unsigned int hexValue);
function RL_GetColor( int $hexValue ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetColor( $hexValue ); }

/// Get Color from a source pixel pointer of certain format
// Color GetPixelColor(void* srcPtr , int format);
function RL_GetPixelColor( object $srcPtr , int $format ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetPixelColor( $srcPtr , $format ); }

/// Set color formatted into destination pixel pointer
// void SetPixelColor(void* dstPtr , Color color , int format);
function RL_SetPixelColor( object $dstPtr , object $color , int $format ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetPixelColor( $dstPtr , $color , $format ); }

/// Get pixel data size in bytes for certain format
// int GetPixelDataSize(int width , int height , int format);
function RL_GetPixelDataSize( int $width , int $height , int $format ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetPixelDataSize( $width , $height , $format ); }

/// Get the default Font
// Font GetFontDefault(void);
function RL_GetFontDefault(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetFontDefault(  ); }

/// Load font from file into GPU memory (VRAM)
// Font LoadFont(const char* fileName);
function RL_LoadFont( string $fileName ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadFont( $fileName ); }

/// Load font from file with extended parameters, use NULL for fontChars and 0 for glyphCount to load the default character set
// Font LoadFontEx(const char* fileName , int fontSize , int* fontChars , int glyphCount);
//XXX function RL_LoadFontEx( string $fileName , int $fontSize , int /*ref:int*/&$fontChars , int $glyphCount ) : object { global $RAYLIB_FFI; static $__c_ref__fontChars = null ; $__c_ref__fontChars ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->LoadFontEx( $fileName , $fontSize , FFI::addr($__c_ref__fontChars) , $glyphCount ); $fontChars = $__c_ref__fontChars->cdata ; return $__result__; }

/// Load font from Image (XNA style)
// Font LoadFontFromImage(Image image , Color key , int firstChar);
function RL_LoadFontFromImage( object $image , object $key , int $firstChar ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadFontFromImage( $image , $key , $firstChar ); }

/// Load font from memory buffer, fileType refers to extension: i.e. '.ttf'
// Font LoadFontFromMemory(const char* fileType , const unsigned char* fileData , int dataSize , int fontSize , int* fontChars , int glyphCount);
function RL_LoadFontFromMemory( string $fileType , string $fileData , int $dataSize , int $fontSize , int /*ref:int*/&$fontChars , int $glyphCount ) : object { global $RAYLIB_FFI; static $__c_ref__fontChars = null ; $__c_ref__fontChars ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->LoadFontFromMemory( $fileType , $fileData , $dataSize , $fontSize , FFI::addr($__c_ref__fontChars) , $glyphCount ); $fontChars = $__c_ref__fontChars->cdata ; return $__result__; }

/// Check if a font is ready
// bool IsFontReady(Font font);
function RL_IsFontReady( object $font ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsFontReady( $font ); }

/// Load font data for further use
// GlyphInfo* LoadFontData(const unsigned char* fileData , int dataSize , int fontSize , int* fontChars , int glyphCount , int type);
function RL_LoadFontData( string $fileData , int $dataSize , int $fontSize , int /*ref:int*/&$fontChars , int $glyphCount , int $type ) : object { global $RAYLIB_FFI; static $__c_ref__fontChars = null ; $__c_ref__fontChars ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->LoadFontData( $fileData , $dataSize , $fontSize , FFI::addr($__c_ref__fontChars) , $glyphCount , $type ); $fontChars = $__c_ref__fontChars->cdata ; return $__result__; }

/// Generate image font atlas using chars info
// Image GenImageFontAtlas(const GlyphInfo* chars , Rectangle** recs , int glyphCount , int fontSize , int padding , int packMethod);
function RL_GenImageFontAtlas( object $chars , object $recs , int $glyphCount , int $fontSize , int $padding , int $packMethod ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenImageFontAtlas( $chars , $recs , $glyphCount , $fontSize , $padding , $packMethod ); }

/// Unload font chars info data (RAM)
// void UnloadFontData(GlyphInfo* chars , int glyphCount);
function RL_UnloadFontData( object $chars , int $glyphCount ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadFontData( $chars , $glyphCount ); }

/// Unload font from GPU memory (VRAM)
// void UnloadFont(Font font);
function RL_UnloadFont( object $font ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadFont( $font ); }

/// Export font as code file, returns true on success
// bool ExportFontAsCode(Font font , const char* fileName);
function RL_ExportFontAsCode( object $font , string $fileName ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->ExportFontAsCode( $font , $fileName ); }

/// Draw current FPS
// void DrawFPS(int posX , int posY);
function RL_DrawFPS( int $posX , int $posY ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawFPS( $posX , $posY ); }

/// Draw text (using default font)
// void DrawText(const char* text , int posX , int posY , int fontSize , Color color);
function RL_DrawText( string $text , int $posX , int $posY , int $fontSize , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawText( $text , $posX , $posY , $fontSize , $color ); }

/// Draw text using font and additional parameters
// void DrawTextEx(Font font , const char* text , Vector2 position , float fontSize , float spacing , Color tint);
function RL_DrawTextEx( object $font , string $text , object $position , float $fontSize , float $spacing , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTextEx( $font , $text , $position , $fontSize , $spacing , $tint ); }

/// Draw text using Font and pro parameters (rotation)
// void DrawTextPro(Font font , const char* text , Vector2 position , Vector2 origin , float rotation , float fontSize , float spacing , Color tint);
function RL_DrawTextPro( object $font , string $text , object $position , object $origin , float $rotation , float $fontSize , float $spacing , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTextPro( $font , $text , $position , $origin , $rotation , $fontSize , $spacing , $tint ); }

/// Draw one character (codepoint)
// void DrawTextCodepoint(Font font , int codepoint , Vector2 position , float fontSize , Color tint);
function RL_DrawTextCodepoint( object $font , int $codepoint , object $position , float $fontSize , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTextCodepoint( $font , $codepoint , $position , $fontSize , $tint ); }

/// Draw multiple character (codepoint)
// void DrawTextCodepoints(Font font , const int* codepoints , int count , Vector2 position , float fontSize , float spacing , Color tint);
function RL_DrawTextCodepoints( object $font , int /*ref:int*/&$codepoints , int $count , object $position , float $fontSize , float $spacing , object $tint ) : void { global $RAYLIB_FFI; static $__c_ref__codepoints = null ; $__c_ref__codepoints ??= FFI::new("int"); $RAYLIB_FFI->DrawTextCodepoints( $font , FFI::addr($__c_ref__codepoints) , $count , $position , $fontSize , $spacing , $tint ); $codepoints = $__c_ref__codepoints->cdata ; }

/// Measure string width for default font
// int MeasureText(const char* text , int fontSize);
function RL_MeasureText( string $text , int $fontSize ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->MeasureText( $text , $fontSize ); }

/// Measure string size for Font
// Vector2 MeasureTextEx(Font font , const char* text , float fontSize , float spacing);
function RL_MeasureTextEx( object $font , string $text , float $fontSize , float $spacing ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MeasureTextEx( $font , $text , $fontSize , $spacing ); }

/// Get glyph index position in font for a codepoint (unicode character), fallback to '?' if not found
// int GetGlyphIndex(Font font , int codepoint);
function RL_GetGlyphIndex( object $font , int $codepoint ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGlyphIndex( $font , $codepoint ); }

/// Get glyph font info data for a codepoint (unicode character), fallback to '?' if not found
// GlyphInfo GetGlyphInfo(Font font , int codepoint);
function RL_GetGlyphInfo( object $font , int $codepoint ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGlyphInfo( $font , $codepoint ); }

/// Get glyph rectangle in font atlas for a codepoint (unicode character), fallback to '?' if not found
// Rectangle GetGlyphAtlasRec(Font font , int codepoint);
function RL_GetGlyphAtlasRec( object $font , int $codepoint ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetGlyphAtlasRec( $font , $codepoint ); }

/// Get next codepoint in a UTF-8 encoded string, 0x3f('?') is returned on failure
// int GetCodepoint(const char* text , int* codepointSize);
function RL_GetCodepoint( string $text , int /*ref:int*/&$codepointSize ) : int { global $RAYLIB_FFI; static $__c_ref__codepointSize = null ; $__c_ref__codepointSize ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->GetCodepoint( $text , FFI::addr($__c_ref__codepointSize) ); $codepointSize = $__c_ref__codepointSize->cdata ; return $__result__; }

/// Get next codepoint in a UTF-8 encoded string, 0x3f('?') is returned on failure
// int GetCodepointNext(const char* text , int* codepointSize);
function RL_GetCodepointNext( string $text , int /*ref:int*/&$codepointSize ) : int { global $RAYLIB_FFI; static $__c_ref__codepointSize = null ; $__c_ref__codepointSize ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->GetCodepointNext( $text , FFI::addr($__c_ref__codepointSize) ); $codepointSize = $__c_ref__codepointSize->cdata ; return $__result__; }

/// Get previous codepoint in a UTF-8 encoded string, 0x3f('?') is returned on failure
// int GetCodepointPrevious(const char* text , int* codepointSize);
function RL_GetCodepointPrevious( string $text , int /*ref:int*/&$codepointSize ) : int { global $RAYLIB_FFI; static $__c_ref__codepointSize = null ; $__c_ref__codepointSize ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->GetCodepointPrevious( $text , FFI::addr($__c_ref__codepointSize) ); $codepointSize = $__c_ref__codepointSize->cdata ; return $__result__; }

/// Load UTF-8 text encoded from codepoints array
// char* LoadUTF8(const int* codepoints , int length);
function RL_LoadUTF8( int /*ref:int*/&$codepoints , int $length ) : string { global $RAYLIB_FFI; static $__c_ref__codepoints = null ; $__c_ref__codepoints ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->LoadUTF8( FFI::addr($__c_ref__codepoints) , $length ); $codepoints = $__c_ref__codepoints->cdata ; return $__result__; }

/// Unload UTF-8 text encoded from codepoints array
// void UnloadUTF8(char* text);
function RL_UnloadUTF8( string $text ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadUTF8( $text ); }

/// Load all codepoints from a UTF-8 text string, codepoints count returned by parameter
// int* LoadCodepoints(const char* text , int* count);
function RL_LoadCodepoints( string $text , int /*ref:int*/&$count ) : object { global $RAYLIB_FFI; static $__c_ref__count = null ; $__c_ref__count ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->LoadCodepoints( $text , FFI::addr($__c_ref__count) ); $count = $__c_ref__count->cdata ; return $__result__; }

/// Unload codepoints data from memory
// void UnloadCodepoints(int* codepoints);
function RL_UnloadCodepoints( int /*ref:int*/&$codepoints ) : void { global $RAYLIB_FFI; static $__c_ref__codepoints = null ; $__c_ref__codepoints ??= FFI::new("int"); $RAYLIB_FFI->UnloadCodepoints( FFI::addr($__c_ref__codepoints) ); $codepoints = $__c_ref__codepoints->cdata ; }

/// Get total number of codepoints in a UTF-8 encoded string
// int GetCodepointCount(const char* text);
function RL_GetCodepointCount( string $text ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCodepointCount( $text ); }

/// Encode one codepoint into UTF-8 byte array (array length returned as parameter)
// const char* CodepointToUTF8(int codepoint , int* utf8Size);
function RL_CodepointToUTF8( int $codepoint , int /*ref:int*/&$utf8Size ) : string { global $RAYLIB_FFI; static $__c_ref__utf8Size = null ; $__c_ref__utf8Size ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->CodepointToUTF8( $codepoint , FFI::addr($__c_ref__utf8Size) ); $utf8Size = $__c_ref__utf8Size->cdata ; return $__result__; }

/// Copy one string to another, returns bytes copied
// int TextCopy(char* dst , const char* src);
function RL_TextCopy( string $dst , string $src ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->TextCopy( $dst , $src ); }

/// Check if two text string are equal
// bool TextIsEqual(const char* text1 , const char* text2);
function RL_TextIsEqual( string $text1 , string $text2 ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->TextIsEqual( $text1 , $text2 ); }

/// Get a piece of a text string
// const char* TextSubtext(const char* text , int position , int length);
function RL_TextSubtext( string $text , int $position , int $length ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->TextSubtext( $text , $position , $length ); }

/// Replace text string (WARNING: memory must be freed!)
// char* TextReplace(char* text , const char* replace , const char* by);
function RL_TextReplace( string $text , string $replace , string $by ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->TextReplace( $text , $replace , $by ); }

/// Insert text in a position (WARNING: memory must be freed!)
// char* TextInsert(const char* text , const char* insert , int position);
function RL_TextInsert( string $text , string $insert , int $position ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->TextInsert( $text , $insert , $position ); }

/// Join text strings with delimiter
// const char* TextJoin(const char** textList , int count , const char* delimiter);
function RL_TextJoin( object $textList , int $count , string $delimiter ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->TextJoin( $textList , $count , $delimiter ); }

/// Split text into multiple strings
// const char** TextSplit(const char* text , char delimiter , int* count);
function RL_TextSplit( string $text , string $delimiter , int /*ref:int*/&$count ) : object { global $RAYLIB_FFI; static $__c_ref__count = null ; $__c_ref__count ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->TextSplit( $text , $delimiter , FFI::addr($__c_ref__count) ); $count = $__c_ref__count->cdata ; return $__result__; }

/// Append text at specific position and move cursor!
// void TextAppend(char* text , const char* append , int* position);
function RL_TextAppend( string $text , string $append , int /*ref:int*/&$position ) : void { global $RAYLIB_FFI; static $__c_ref__position = null ; $__c_ref__position ??= FFI::new("int"); $RAYLIB_FFI->TextAppend( $text , $append , FFI::addr($__c_ref__position) ); $position = $__c_ref__position->cdata ; }

/// Find first text occurrence within a string
// int TextFindIndex(const char* text , const char* find);
function RL_TextFindIndex( string $text , string $find ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->TextFindIndex( $text , $find ); }

/// Get upper case version of provided string
// const char* TextToUpper(const char* text);
function RL_TextToUpper( string $text ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->TextToUpper( $text ); }

/// Get lower case version of provided string
// const char* TextToLower(const char* text);
function RL_TextToLower( string $text ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->TextToLower( $text ); }

/// Get Pascal case notation version of provided string
// const char* TextToPascal(const char* text);
function RL_TextToPascal( string $text ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->TextToPascal( $text ); }

/// Get text length, checks for '\0' ending
// unsigned int TextLength(const char* text);
function RL_TextLength( string $text ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->TextLength( $text ); }

/// Text formatting with variables (sprintf() style)
// const char* TextFormat(const char* text , ...);
function RL_TextFormat( string $text , ...$_ ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->TextFormat( $text , ...$_ ); }

/// Get integer value from text (negative values not supported)
// int TextToInteger(const char* text);
function RL_TextToInteger( string $text ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->TextToInteger( $text ); }

/// Draw a line in 3D world space
// void DrawLine3D(Vector3 startPos , Vector3 endPos , Color color);
function RL_DrawLine3D( object $startPos , object $endPos , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawLine3D( $startPos , $endPos , $color ); }

/// Draw a point in 3D space, actually a small line
// void DrawPoint3D(Vector3 position , Color color);
function RL_DrawPoint3D( object $position , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawPoint3D( $position , $color ); }

/// Draw a circle in 3D world space
// void DrawCircle3D(Vector3 center , float radius , Vector3 rotationAxis , float rotationAngle , Color color);
function RL_DrawCircle3D( object $center , float $radius , object $rotationAxis , float $rotationAngle , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCircle3D( $center , $radius , $rotationAxis , $rotationAngle , $color ); }

/// Draw a color-filled triangle (vertex in counter-clockwise order!)
// void DrawTriangle3D(Vector3 v1 , Vector3 v2 , Vector3 v3 , Color color);
function RL_DrawTriangle3D( object $v1 , object $v2 , object $v3 , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTriangle3D( $v1 , $v2 , $v3 , $color ); }

/// Draw a triangle strip defined by points
// void DrawTriangleStrip3D(Vector3* points , int pointCount , Color color);
function RL_DrawTriangleStrip3D( object $points , int $pointCount , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawTriangleStrip3D( $points , $pointCount , $color ); }

/// Draw cube
// void DrawCube(Vector3 position , float width , float height , float length , Color color);
function RL_DrawCube( object $position , float $width , float $height , float $length , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCube( $position , $width , $height , $length , $color ); }

/// Draw cube (Vector version)
// void DrawCubeV(Vector3 position , Vector3 size , Color color);
function RL_DrawCubeV( object $position , object $size , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCubeV( $position , $size , $color ); }

/// Draw cube wires
// void DrawCubeWires(Vector3 position , float width , float height , float length , Color color);
function RL_DrawCubeWires( object $position , float $width , float $height , float $length , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCubeWires( $position , $width , $height , $length , $color ); }

/// Draw cube wires (Vector version)
// void DrawCubeWiresV(Vector3 position , Vector3 size , Color color);
function RL_DrawCubeWiresV( object $position , object $size , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCubeWiresV( $position , $size , $color ); }

/// Draw sphere
// void DrawSphere(Vector3 centerPos , float radius , Color color);
function RL_DrawSphere( object $centerPos , float $radius , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawSphere( $centerPos , $radius , $color ); }

/// Draw sphere with extended parameters
// void DrawSphereEx(Vector3 centerPos , float radius , int rings , int slices , Color color);
function RL_DrawSphereEx( object $centerPos , float $radius , int $rings , int $slices , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawSphereEx( $centerPos , $radius , $rings , $slices , $color ); }

/// Draw sphere wires
// void DrawSphereWires(Vector3 centerPos , float radius , int rings , int slices , Color color);
function RL_DrawSphereWires( object $centerPos , float $radius , int $rings , int $slices , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawSphereWires( $centerPos , $radius , $rings , $slices , $color ); }

/// Draw a cylinder/cone
// void DrawCylinder(Vector3 position , float radiusTop , float radiusBottom , float height , int slices , Color color);
function RL_DrawCylinder( object $position , float $radiusTop , float $radiusBottom , float $height , int $slices , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCylinder( $position , $radiusTop , $radiusBottom , $height , $slices , $color ); }

/// Draw a cylinder with base at startPos and top at endPos
// void DrawCylinderEx(Vector3 startPos , Vector3 endPos , float startRadius , float endRadius , int sides , Color color);
function RL_DrawCylinderEx( object $startPos , object $endPos , float $startRadius , float $endRadius , int $sides , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCylinderEx( $startPos , $endPos , $startRadius , $endRadius , $sides , $color ); }

/// Draw a cylinder/cone wires
// void DrawCylinderWires(Vector3 position , float radiusTop , float radiusBottom , float height , int slices , Color color);
function RL_DrawCylinderWires( object $position , float $radiusTop , float $radiusBottom , float $height , int $slices , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCylinderWires( $position , $radiusTop , $radiusBottom , $height , $slices , $color ); }

/// Draw a cylinder wires with base at startPos and top at endPos
// void DrawCylinderWiresEx(Vector3 startPos , Vector3 endPos , float startRadius , float endRadius , int sides , Color color);
function RL_DrawCylinderWiresEx( object $startPos , object $endPos , float $startRadius , float $endRadius , int $sides , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCylinderWiresEx( $startPos , $endPos , $startRadius , $endRadius , $sides , $color ); }

/// Draw a capsule with the center of its sphere caps at startPos and endPos
// void DrawCapsule(Vector3 startPos , Vector3 endPos , float radius , int slices , int rings , Color color);
function RL_DrawCapsule( object $startPos , object $endPos , float $radius , int $slices , int $rings , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCapsule( $startPos , $endPos , $radius , $slices , $rings , $color ); }

/// Draw capsule wireframe with the center of its sphere caps at startPos and endPos
// void DrawCapsuleWires(Vector3 startPos , Vector3 endPos , float radius , int slices , int rings , Color color);
function RL_DrawCapsuleWires( object $startPos , object $endPos , float $radius , int $slices , int $rings , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawCapsuleWires( $startPos , $endPos , $radius , $slices , $rings , $color ); }

/// Draw a plane XZ
// void DrawPlane(Vector3 centerPos , Vector2 size , Color color);
function RL_DrawPlane( object $centerPos , object $size , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawPlane( $centerPos , $size , $color ); }

/// Draw a ray line
// void DrawRay(Ray ray , Color color);
function RL_DrawRay( object $ray , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawRay( $ray , $color ); }

/// Draw a grid (centered at (0, 0, 0))
// void DrawGrid(int slices , float spacing);
function RL_DrawGrid( int $slices , float $spacing ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawGrid( $slices , $spacing ); }

/// Load model from files (meshes and materials)
// Model LoadModel(const char* fileName);
function RL_LoadModel( string $fileName ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadModel( $fileName ); }

/// Load model from generated mesh (default material)
// Model LoadModelFromMesh(Mesh mesh);
function RL_LoadModelFromMesh( object $mesh ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadModelFromMesh( $mesh ); }

/// Check if a model is ready
// bool IsModelReady(Model model);
function RL_IsModelReady( object $model ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsModelReady( $model ); }

/// Unload model (including meshes) from memory (RAM and/or VRAM)
// void UnloadModel(Model model);
function RL_UnloadModel( object $model ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadModel( $model ); }

/// Compute model bounding box limits (considers all meshes)
// BoundingBox GetModelBoundingBox(Model model);
function RL_GetModelBoundingBox( object $model ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetModelBoundingBox( $model ); }

/// Draw a model (with texture if set)
// void DrawModel(Model model , Vector3 position , float scale , Color tint);
function RL_DrawModel( object $model , object $position , float $scale , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawModel( $model , $position , $scale , $tint ); }

/// Draw a model with extended parameters
// void DrawModelEx(Model model , Vector3 position , Vector3 rotationAxis , float rotationAngle , Vector3 scale , Color tint);
function RL_DrawModelEx( object $model , object $position , object $rotationAxis , float $rotationAngle , object $scale , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawModelEx( $model , $position , $rotationAxis , $rotationAngle , $scale , $tint ); }

/// Draw a model wires (with texture if set)
// void DrawModelWires(Model model , Vector3 position , float scale , Color tint);
function RL_DrawModelWires( object $model , object $position , float $scale , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawModelWires( $model , $position , $scale , $tint ); }

/// Draw a model wires (with texture if set) with extended parameters
// void DrawModelWiresEx(Model model , Vector3 position , Vector3 rotationAxis , float rotationAngle , Vector3 scale , Color tint);
function RL_DrawModelWiresEx( object $model , object $position , object $rotationAxis , float $rotationAngle , object $scale , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawModelWiresEx( $model , $position , $rotationAxis , $rotationAngle , $scale , $tint ); }

/// Draw bounding box (wires)
// void DrawBoundingBox(BoundingBox box , Color color);
function RL_DrawBoundingBox( object $box , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawBoundingBox( $box , $color ); }

/// Draw a billboard texture
// void DrawBillboard(Camera camera , Texture2D texture , Vector3 position , float size , Color tint);
function RL_DrawBillboard( object $camera , object $texture , object $position , float $size , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawBillboard( $camera , $texture , $position , $size , $tint ); }

/// Draw a billboard texture defined by source
// void DrawBillboardRec(Camera camera , Texture2D texture , Rectangle source , Vector3 position , Vector2 size , Color tint);
function RL_DrawBillboardRec( object $camera , object $texture , object $source , object $position , object $size , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawBillboardRec( $camera , $texture , $source , $position , $size , $tint ); }

/// Draw a billboard texture defined by source and rotation
// void DrawBillboardPro(Camera camera , Texture2D texture , Rectangle source , Vector3 position , Vector3 up , Vector2 size , Vector2 origin , float rotation , Color tint);
function RL_DrawBillboardPro( object $camera , object $texture , object $source , object $position , object $up , object $size , object $origin , float $rotation , object $tint ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawBillboardPro( $camera , $texture , $source , $position , $up , $size , $origin , $rotation , $tint ); }

/// Upload mesh vertex data in GPU and provide VAO/VBO ids
// void UploadMesh(Mesh* mesh , bool dynamic);
function RL_UploadMesh( object /*ref*/$mesh , bool $dynamic ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UploadMesh( FFI::addr($mesh) , $dynamic ); }

/// Update mesh vertex data in GPU for a specific buffer index
// void UpdateMeshBuffer(Mesh mesh , int index , const void* data , int dataSize , int offset);
function RL_UpdateMeshBuffer( object $mesh , int $index , object $data , int $dataSize , int $offset ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UpdateMeshBuffer( $mesh , $index , $data , $dataSize , $offset ); }

/// Unload mesh data from CPU and GPU
// void UnloadMesh(Mesh mesh);
function RL_UnloadMesh( object $mesh ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadMesh( $mesh ); }

/// Draw a 3d mesh with material and transform
// void DrawMesh(Mesh mesh , Material material , Matrix transform);
function RL_DrawMesh( object $mesh , object $material , object $transform ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawMesh( $mesh , $material , $transform ); }

/// Draw multiple mesh instances with material and different transforms
// void DrawMeshInstanced(Mesh mesh , Material material , const Matrix* transforms , int instances);
function RL_DrawMeshInstanced( object $mesh , object $material , object $transforms , int $instances ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DrawMeshInstanced( $mesh , $material , $transforms , $instances ); }

/// Export mesh data to file, returns true on success
// bool ExportMesh(Mesh mesh , const char* fileName);
function RL_ExportMesh( object $mesh , string $fileName ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->ExportMesh( $mesh , $fileName ); }

/// Compute mesh bounding box limits
// BoundingBox GetMeshBoundingBox(Mesh mesh);
function RL_GetMeshBoundingBox( object $mesh ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMeshBoundingBox( $mesh ); }

/// Compute mesh tangents
// void GenMeshTangents(Mesh* mesh);
function RL_GenMeshTangents( object /*ref*/$mesh ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GenMeshTangents( FFI::addr($mesh) ); }

/// Generate polygonal mesh
// Mesh GenMeshPoly(int sides , float radius);
function RL_GenMeshPoly( int $sides , float $radius ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshPoly( $sides , $radius ); }

/// Generate plane mesh (with subdivisions)
// Mesh GenMeshPlane(float width , float length , int resX , int resZ);
function RL_GenMeshPlane( float $width , float $length , int $resX , int $resZ ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshPlane( $width , $length , $resX , $resZ ); }

/// Generate cuboid mesh
// Mesh GenMeshCube(float width , float height , float length);
function RL_GenMeshCube( float $width , float $height , float $length ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshCube( $width , $height , $length ); }

/// Generate sphere mesh (standard sphere)
// Mesh GenMeshSphere(float radius , int rings , int slices);
function RL_GenMeshSphere( float $radius , int $rings , int $slices ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshSphere( $radius , $rings , $slices ); }

/// Generate half-sphere mesh (no bottom cap)
// Mesh GenMeshHemiSphere(float radius , int rings , int slices);
function RL_GenMeshHemiSphere( float $radius , int $rings , int $slices ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshHemiSphere( $radius , $rings , $slices ); }

/// Generate cylinder mesh
// Mesh GenMeshCylinder(float radius , float height , int slices);
function RL_GenMeshCylinder( float $radius , float $height , int $slices ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshCylinder( $radius , $height , $slices ); }

/// Generate cone/pyramid mesh
// Mesh GenMeshCone(float radius , float height , int slices);
function RL_GenMeshCone( float $radius , float $height , int $slices ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshCone( $radius , $height , $slices ); }

/// Generate torus mesh
// Mesh GenMeshTorus(float radius , float size , int radSeg , int sides);
function RL_GenMeshTorus( float $radius , float $size , int $radSeg , int $sides ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshTorus( $radius , $size , $radSeg , $sides ); }

/// Generate trefoil knot mesh
// Mesh GenMeshKnot(float radius , float size , int radSeg , int sides);
function RL_GenMeshKnot( float $radius , float $size , int $radSeg , int $sides ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshKnot( $radius , $size , $radSeg , $sides ); }

/// Generate heightmap mesh from image data
// Mesh GenMeshHeightmap(Image heightmap , Vector3 size);
function RL_GenMeshHeightmap( object $heightmap , object $size ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshHeightmap( $heightmap , $size ); }

/// Generate cubes-based map mesh from image data
// Mesh GenMeshCubicmap(Image cubicmap , Vector3 cubeSize);
function RL_GenMeshCubicmap( object $cubicmap , object $cubeSize ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GenMeshCubicmap( $cubicmap , $cubeSize ); }

/// Load materials from model file
// Material* LoadMaterials(const char* fileName , int* materialCount);
function RL_LoadMaterials( string $fileName , int /*ref:int*/&$materialCount ) : object { global $RAYLIB_FFI; static $__c_ref__materialCount = null ; $__c_ref__materialCount ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->LoadMaterials( $fileName , FFI::addr($__c_ref__materialCount) ); $materialCount = $__c_ref__materialCount->cdata ; return $__result__; }

/// Load default material (Supports: DIFFUSE, SPECULAR, NORMAL maps)
// Material LoadMaterialDefault(void);
function RL_LoadMaterialDefault(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadMaterialDefault(  ); }

/// Check if a material is ready
// bool IsMaterialReady(Material material);
function RL_IsMaterialReady( object $material ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsMaterialReady( $material ); }

/// Unload material from GPU memory (VRAM)
// void UnloadMaterial(Material material);
function RL_UnloadMaterial( object $material ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadMaterial( $material ); }

/// Set texture for a material map type (MATERIAL_MAP_DIFFUSE, MATERIAL_MAP_SPECULAR...)
// void SetMaterialTexture(Material* material , int mapType , Texture2D texture);
function RL_SetMaterialTexture( object /*ref*/$material , int $mapType , object $texture ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetMaterialTexture( FFI::addr($material) , $mapType , $texture ); }

/// Set material for a mesh
// void SetModelMeshMaterial(Model* model , int meshId , int materialId);
function RL_SetModelMeshMaterial( object $model , int $meshId , int $materialId ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetModelMeshMaterial( $model , $meshId , $materialId ); }

/// Load model animations from file
// ModelAnimation* LoadModelAnimations(const char* fileName , unsigned int* animCount);
function RL_LoadModelAnimations( string $fileName , int /*ref:int*/&$animCount ) : object { global $RAYLIB_FFI; static $__c_ref__animCount = null ; $__c_ref__animCount ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->LoadModelAnimations( $fileName , FFI::addr($__c_ref__animCount) ); $animCount = $__c_ref__animCount->cdata ; return $__result__; }

/// Update model animation pose
// void UpdateModelAnimation(Model model , ModelAnimation anim , int frame);
function RL_UpdateModelAnimation( object $model , object $anim , int $frame ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UpdateModelAnimation( $model , $anim , $frame ); }

/// Unload animation data
// void UnloadModelAnimation(ModelAnimation anim);
function RL_UnloadModelAnimation( object $anim ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadModelAnimation( $anim ); }

/// Unload animation array data
// void UnloadModelAnimations(ModelAnimation* animations , unsigned int count);
function RL_UnloadModelAnimations( object $animations , int $count ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadModelAnimations( $animations , $count ); }

/// Check model animation skeleton match
// bool IsModelAnimationValid(Model model , ModelAnimation anim);
function RL_IsModelAnimationValid( object $model , object $anim ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsModelAnimationValid( $model , $anim ); }

/// Check collision between two spheres
// bool CheckCollisionSpheres(Vector3 center1 , float radius1 , Vector3 center2 , float radius2);
function RL_CheckCollisionSpheres( object $center1 , float $radius1 , object $center2 , float $radius2 ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionSpheres( $center1 , $radius1 , $center2 , $radius2 ); }

/// Check collision between two bounding boxes
// bool CheckCollisionBoxes(BoundingBox box1 , BoundingBox box2);
function RL_CheckCollisionBoxes( object $box1 , object $box2 ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionBoxes( $box1 , $box2 ); }

/// Check collision between box and sphere
// bool CheckCollisionBoxSphere(BoundingBox box , Vector3 center , float radius);
function RL_CheckCollisionBoxSphere( object $box , object $center , float $radius ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->CheckCollisionBoxSphere( $box , $center , $radius ); }

/// Get collision info between ray and sphere
// RayCollision GetRayCollisionSphere(Ray ray , Vector3 center , float radius);
function RL_GetRayCollisionSphere( object $ray , object $center , float $radius ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetRayCollisionSphere( $ray , $center , $radius ); }

/// Get collision info between ray and box
// RayCollision GetRayCollisionBox(Ray ray , BoundingBox box);
function RL_GetRayCollisionBox( object $ray , object $box ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetRayCollisionBox( $ray , $box ); }

/// Get collision info between ray and mesh
// RayCollision GetRayCollisionMesh(Ray ray , Mesh mesh , Matrix transform);
function RL_GetRayCollisionMesh( object $ray , object $mesh , object $transform ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetRayCollisionMesh( $ray , $mesh , $transform ); }

/// Get collision info between ray and triangle
// RayCollision GetRayCollisionTriangle(Ray ray , Vector3 p1 , Vector3 p2 , Vector3 p3);
function RL_GetRayCollisionTriangle( object $ray , object $p1 , object $p2 , object $p3 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetRayCollisionTriangle( $ray , $p1 , $p2 , $p3 ); }

/// Get collision info between ray and quad
// RayCollision GetRayCollisionQuad(Ray ray , Vector3 p1 , Vector3 p2 , Vector3 p3 , Vector3 p4);
function RL_GetRayCollisionQuad( object $ray , object $p1 , object $p2 , object $p3 , object $p4 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetRayCollisionQuad( $ray , $p1 , $p2 , $p3 , $p4 ); }

/// Initialize audio device and context
// void InitAudioDevice(void);
function RL_InitAudioDevice(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->InitAudioDevice(  ); }

/// Close the audio device and context
// void CloseAudioDevice(void);
function RL_CloseAudioDevice(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->CloseAudioDevice(  ); }

/// Check if audio device has been initialized successfully
// bool IsAudioDeviceReady(void);
function RL_IsAudioDeviceReady(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsAudioDeviceReady(  ); }

/// Set master volume (listener)
// void SetMasterVolume(float volume);
function RL_SetMasterVolume( float $volume ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetMasterVolume( $volume ); }

/// Load wave data from file
// Wave LoadWave(const char* fileName);
function RL_LoadWave( string $fileName ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadWave( $fileName ); }

/// Load wave from memory buffer, fileType refers to extension: i.e. '.wav'
// Wave LoadWaveFromMemory(const char* fileType , const unsigned char* fileData , int dataSize);
function RL_LoadWaveFromMemory( string $fileType , string $fileData , int $dataSize ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadWaveFromMemory( $fileType , $fileData , $dataSize ); }

/// Checks if wave data is ready
// bool IsWaveReady(Wave wave);
function RL_IsWaveReady( object $wave ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsWaveReady( $wave ); }

/// Load sound from file
// Sound LoadSound(const char* fileName);
function RL_LoadSound( string $fileName ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadSound( $fileName ); }

/// Load sound from wave data
// Sound LoadSoundFromWave(Wave wave);
function RL_LoadSoundFromWave( object $wave ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadSoundFromWave( $wave ); }

/// Checks if a sound is ready
// bool IsSoundReady(Sound sound);
function RL_IsSoundReady( object $sound ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsSoundReady( $sound ); }

/// Update sound buffer with new data
// void UpdateSound(Sound sound , const void* data , int sampleCount);
function RL_UpdateSound( object $sound , object $data , int $sampleCount ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UpdateSound( $sound , $data , $sampleCount ); }

/// Unload wave data
// void UnloadWave(Wave wave);
function RL_UnloadWave( object $wave ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadWave( $wave ); }

/// Unload sound
// void UnloadSound(Sound sound);
function RL_UnloadSound( object $sound ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadSound( $sound ); }

/// Export wave data to file, returns true on success
// bool ExportWave(Wave wave , const char* fileName);
function RL_ExportWave( object $wave , string $fileName ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->ExportWave( $wave , $fileName ); }

/// Export wave sample data to code (.h), returns true on success
// bool ExportWaveAsCode(Wave wave , const char* fileName);
function RL_ExportWaveAsCode( object $wave , string $fileName ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->ExportWaveAsCode( $wave , $fileName ); }

/// Play a sound
// void PlaySound(Sound sound);
function RL_PlaySound( object $sound ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->PlaySound( $sound ); }

/// Stop playing a sound
// void StopSound(Sound sound);
function RL_StopSound( object $sound ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->StopSound( $sound ); }

/// Pause a sound
// void PauseSound(Sound sound);
function RL_PauseSound( object $sound ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->PauseSound( $sound ); }

/// Resume a paused sound
// void ResumeSound(Sound sound);
function RL_ResumeSound( object $sound ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ResumeSound( $sound ); }

/// Check if a sound is currently playing
// bool IsSoundPlaying(Sound sound);
function RL_IsSoundPlaying( object $sound ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsSoundPlaying( $sound ); }

/// Set volume for a sound (1.0 is max level)
// void SetSoundVolume(Sound sound , float volume);
function RL_SetSoundVolume( object $sound , float $volume ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetSoundVolume( $sound , $volume ); }

/// Set pitch for a sound (1.0 is base level)
// void SetSoundPitch(Sound sound , float pitch);
function RL_SetSoundPitch( object $sound , float $pitch ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetSoundPitch( $sound , $pitch ); }

/// Set pan for a sound (0.5 is center)
// void SetSoundPan(Sound sound , float pan);
function RL_SetSoundPan( object $sound , float $pan ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetSoundPan( $sound , $pan ); }

/// Copy a wave to a new wave
// Wave WaveCopy(Wave wave);
function RL_WaveCopy( object $wave ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->WaveCopy( $wave ); }

/// Crop a wave to defined samples range
// void WaveCrop(Wave* wave , int initSample , int finalSample);
function RL_WaveCrop( object $wave , int $initSample , int $finalSample ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->WaveCrop( $wave , $initSample , $finalSample ); }

/// Convert wave data to desired format
// void WaveFormat(Wave* wave , int sampleRate , int sampleSize , int channels);
function RL_WaveFormat( object $wave , int $sampleRate , int $sampleSize , int $channels ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->WaveFormat( $wave , $sampleRate , $sampleSize , $channels ); }

/// Load samples data from wave as a 32bit float data array
// float* LoadWaveSamples(Wave wave);
function RL_LoadWaveSamples( object $wave ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadWaveSamples( $wave ); }

/// Unload samples data loaded with LoadWaveSamples()
// void UnloadWaveSamples(float* samples);
function RL_UnloadWaveSamples( object $samples ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadWaveSamples( $samples ); }

/// Load music stream from file
// Music LoadMusicStream(const char* fileName);
function RL_LoadMusicStream( string $fileName ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadMusicStream( $fileName ); }

/// Load music stream from data
// Music LoadMusicStreamFromMemory(const char* fileType , const unsigned char* data , int dataSize);
function RL_LoadMusicStreamFromMemory( string $fileType , string $data , int $dataSize ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadMusicStreamFromMemory( $fileType , $data , $dataSize ); }

/// Checks if a music stream is ready
// bool IsMusicReady(Music music);
function RL_IsMusicReady( object $music ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsMusicReady( $music ); }

/// Unload music stream
// void UnloadMusicStream(Music music);
function RL_UnloadMusicStream( object $music ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadMusicStream( $music ); }

/// Start music playing
// void PlayMusicStream(Music music);
function RL_PlayMusicStream( object $music ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->PlayMusicStream( $music ); }

/// Check if music is playing
// bool IsMusicStreamPlaying(Music music);
function RL_IsMusicStreamPlaying( object $music ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsMusicStreamPlaying( $music ); }

/// Updates buffers for music streaming
// void UpdateMusicStream(Music music);
function RL_UpdateMusicStream( object $music ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UpdateMusicStream( $music ); }

/// Stop music playing
// void StopMusicStream(Music music);
function RL_StopMusicStream( object $music ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->StopMusicStream( $music ); }

/// Pause music playing
// void PauseMusicStream(Music music);
function RL_PauseMusicStream( object $music ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->PauseMusicStream( $music ); }

/// Resume playing paused music
// void ResumeMusicStream(Music music);
function RL_ResumeMusicStream( object $music ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ResumeMusicStream( $music ); }

/// Seek music to a position (in seconds)
// void SeekMusicStream(Music music , float position);
function RL_SeekMusicStream( object $music , float $position ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SeekMusicStream( $music , $position ); }

/// Set volume for music (1.0 is max level)
// void SetMusicVolume(Music music , float volume);
function RL_SetMusicVolume( object $music , float $volume ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetMusicVolume( $music , $volume ); }

/// Set pitch for a music (1.0 is base level)
// void SetMusicPitch(Music music , float pitch);
function RL_SetMusicPitch( object $music , float $pitch ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetMusicPitch( $music , $pitch ); }

/// Set pan for a music (0.5 is center)
// void SetMusicPan(Music music , float pan);
function RL_SetMusicPan( object $music , float $pan ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetMusicPan( $music , $pan ); }

/// Get music time length (in seconds)
// float GetMusicTimeLength(Music music);
function RL_GetMusicTimeLength( object $music ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMusicTimeLength( $music ); }

/// Get current music time played (in seconds)
// float GetMusicTimePlayed(Music music);
function RL_GetMusicTimePlayed( object $music ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GetMusicTimePlayed( $music ); }

/// Load audio stream (to stream raw audio pcm data)
// AudioStream LoadAudioStream(unsigned int sampleRate , unsigned int sampleSize , unsigned int channels);
function RL_LoadAudioStream( int $sampleRate , int $sampleSize , int $channels ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->LoadAudioStream( $sampleRate , $sampleSize , $channels ); }

/// Checks if an audio stream is ready
// bool IsAudioStreamReady(AudioStream stream);
function RL_IsAudioStreamReady( object $stream ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsAudioStreamReady( $stream ); }

/// Unload audio stream and free memory
// void UnloadAudioStream(AudioStream stream);
function RL_UnloadAudioStream( object $stream ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UnloadAudioStream( $stream ); }

/// Update audio stream buffers with data
// void UpdateAudioStream(AudioStream stream , const void* data , int frameCount);
function RL_UpdateAudioStream( object $stream , object $data , int $frameCount ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UpdateAudioStream( $stream , $data , $frameCount ); }

/// Check if any audio stream buffers requires refill
// bool IsAudioStreamProcessed(AudioStream stream);
function RL_IsAudioStreamProcessed( object $stream ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsAudioStreamProcessed( $stream ); }

/// Play audio stream
// void PlayAudioStream(AudioStream stream);
function RL_PlayAudioStream( object $stream ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->PlayAudioStream( $stream ); }

/// Pause audio stream
// void PauseAudioStream(AudioStream stream);
function RL_PauseAudioStream( object $stream ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->PauseAudioStream( $stream ); }

/// Resume audio stream
// void ResumeAudioStream(AudioStream stream);
function RL_ResumeAudioStream( object $stream ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->ResumeAudioStream( $stream ); }

/// Check if audio stream is playing
// bool IsAudioStreamPlaying(AudioStream stream);
function RL_IsAudioStreamPlaying( object $stream ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->IsAudioStreamPlaying( $stream ); }

/// Stop audio stream
// void StopAudioStream(AudioStream stream);
function RL_StopAudioStream( object $stream ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->StopAudioStream( $stream ); }

/// Set volume for audio stream (1.0 is max level)
// void SetAudioStreamVolume(AudioStream stream , float volume);
function RL_SetAudioStreamVolume( object $stream , float $volume ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetAudioStreamVolume( $stream , $volume ); }

/// Set pitch for audio stream (1.0 is base level)
// void SetAudioStreamPitch(AudioStream stream , float pitch);
function RL_SetAudioStreamPitch( object $stream , float $pitch ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetAudioStreamPitch( $stream , $pitch ); }

/// Set pan for audio stream (0.5 is centered)
// void SetAudioStreamPan(AudioStream stream , float pan);
function RL_SetAudioStreamPan( object $stream , float $pan ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetAudioStreamPan( $stream , $pan ); }

/// Default size for new audio streams
// void SetAudioStreamBufferSizeDefault(int size);
function RL_SetAudioStreamBufferSizeDefault( int $size ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetAudioStreamBufferSizeDefault( $size ); }

/// Audio thread callback to request new data
// void SetAudioStreamCallback(AudioStream stream , AudioCallback callback);
//XXX function RL_SetAudioStreamCallback( object $stream , AudioCallback callback ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->SetAudioStreamCallback( $stream , ); }

/// Attach audio stream processor to stream
// void AttachAudioStreamProcessor(AudioStream stream , AudioCallback processor);
//XXX function RL_AttachAudioStreamProcessor( object $stream , AudioCallback processor ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->AttachAudioStreamProcessor( $stream , ); }

/// Detach audio stream processor from stream
// void DetachAudioStreamProcessor(AudioStream stream , AudioCallback processor);
//XXX function RL_DetachAudioStreamProcessor( object $stream , AudioCallback processor ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DetachAudioStreamProcessor( $stream , ); }

/// Attach audio stream processor to the entire audio pipeline
// void AttachAudioMixedProcessor(AudioCallback processor);
//XXX function RL_AttachAudioMixedProcessor( AudioCallback processor ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->AttachAudioMixedProcessor(  ); }

/// Detach audio stream processor from the entire audio pipeline
// void DetachAudioMixedProcessor(AudioCallback processor);
//XXX function RL_DetachAudioMixedProcessor( AudioCallback processor ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->DetachAudioMixedProcessor(  ); }

/// Clamp float value
// float Clamp(float value , float min , float max);
function RL_Clamp( float $value , float $min , float $max ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Clamp( $value , $min , $max ); }

/// Calculate linear interpolation between two floats
// float Lerp(float start , float end , float amount);
function RL_Lerp( float $start , float $end , float $amount ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Lerp( $start , $end , $amount ); }

/// Normalize input value within input range
// float Normalize(float value , float start , float end);
function RL_Normalize( float $value , float $start , float $end ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Normalize( $value , $start , $end ); }

/// Remap input value within input range to output range
// float Remap(float value , float inputStart , float inputEnd , float outputStart , float outputEnd);
function RL_Remap( float $value , float $inputStart , float $inputEnd , float $outputStart , float $outputEnd ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Remap( $value , $inputStart , $inputEnd , $outputStart , $outputEnd ); }

/// Wrap input value from min to max
// float Wrap(float value , float min , float max);
function RL_Wrap( float $value , float $min , float $max ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Wrap( $value , $min , $max ); }

/// Check whether two given floats are almost equal
// int FloatEquals(float x , float y);
function RL_FloatEquals( float $x , float $y ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->FloatEquals( $x , $y ); }

/// Vector with components value 0.0f
// Vector2 Vector2Zero(void);
function RL_Vector2Zero(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Zero(  ); }

/// Vector with components value 1.0f
// Vector2 Vector2One(void);
function RL_Vector2One(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2One(  ); }

/// Add two vectors (v1 + v2)
// Vector2 Vector2Add(Vector2 v1 , Vector2 v2);
function RL_Vector2Add( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Add( $v1 , $v2 ); }

/// Add vector and float value
// Vector2 Vector2AddValue(Vector2 v , float add);
function RL_Vector2AddValue( object $v , float $add ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2AddValue( $v , $add ); }

/// Subtract two vectors (v1 - v2)
// Vector2 Vector2Subtract(Vector2 v1 , Vector2 v2);
function RL_Vector2Subtract( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Subtract( $v1 , $v2 ); }

/// Subtract vector by float value
// Vector2 Vector2SubtractValue(Vector2 v , float sub);
function RL_Vector2SubtractValue( object $v , float $sub ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2SubtractValue( $v , $sub ); }

/// Calculate vector length
// float Vector2Length(Vector2 v);
function RL_Vector2Length( object $v ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Length( $v ); }

/// Calculate vector square length
// float Vector2LengthSqr(Vector2 v);
function RL_Vector2LengthSqr( object $v ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2LengthSqr( $v ); }

/// Calculate two vectors dot product
// float Vector2DotProduct(Vector2 v1 , Vector2 v2);
function RL_Vector2DotProduct( object $v1 , object $v2 ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2DotProduct( $v1 , $v2 ); }

/// Calculate distance between two vectors
// float Vector2Distance(Vector2 v1 , Vector2 v2);
function RL_Vector2Distance( object $v1 , object $v2 ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Distance( $v1 , $v2 ); }

/// Calculate square distance between two vectors
// float Vector2DistanceSqr(Vector2 v1 , Vector2 v2);
function RL_Vector2DistanceSqr( object $v1 , object $v2 ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2DistanceSqr( $v1 , $v2 ); }

/// Calculate angle between two vectors. NOTE: Angle is calculated from origin point (0, 0)
// float Vector2Angle(Vector2 v1 , Vector2 v2);
function RL_Vector2Angle( object $v1 , object $v2 ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Angle( $v1 , $v2 ); }

/// Calculate angle defined by a two vectors line. NOTE: Parameters need to be normalized. Current implementation should be aligned with glm::angle
// float Vector2LineAngle(Vector2 start , Vector2 end);
function RL_Vector2LineAngle( object $start , object $end ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2LineAngle( $start , $end ); }

/// Scale vector (multiply by value)
// Vector2 Vector2Scale(Vector2 v , float scale);
function RL_Vector2Scale( object $v , float $scale ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Scale( $v , $scale ); }

/// Multiply vector by vector
// Vector2 Vector2Multiply(Vector2 v1 , Vector2 v2);
function RL_Vector2Multiply( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Multiply( $v1 , $v2 ); }

/// Negate vector
// Vector2 Vector2Negate(Vector2 v);
function RL_Vector2Negate( object $v ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Negate( $v ); }

/// Divide vector by vector
// Vector2 Vector2Divide(Vector2 v1 , Vector2 v2);
function RL_Vector2Divide( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Divide( $v1 , $v2 ); }

/// Normalize provided vector
// Vector2 Vector2Normalize(Vector2 v);
function RL_Vector2Normalize( object $v ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Normalize( $v ); }

/// Transforms a Vector2 by a given Matrix
// Vector2 Vector2Transform(Vector2 v , Matrix mat);
function RL_Vector2Transform( object $v , object $mat ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Transform( $v , $mat ); }

/// Calculate linear interpolation between two vectors
// Vector2 Vector2Lerp(Vector2 v1 , Vector2 v2 , float amount);
function RL_Vector2Lerp( object $v1 , object $v2 , float $amount ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Lerp( $v1 , $v2 , $amount ); }

/// Calculate reflected vector to normal
// Vector2 Vector2Reflect(Vector2 v , Vector2 normal);
function RL_Vector2Reflect( object $v , object $normal ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Reflect( $v , $normal ); }

/// Rotate vector by angle
// Vector2 Vector2Rotate(Vector2 v , float angle);
function RL_Vector2Rotate( object $v , float $angle ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Rotate( $v , $angle ); }

/// Move Vector towards target
// Vector2 Vector2MoveTowards(Vector2 v , Vector2 target , float maxDistance);
function RL_Vector2MoveTowards( object $v , object $target , float $maxDistance ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2MoveTowards( $v , $target , $maxDistance ); }

/// Invert the given vector
// Vector2 Vector2Invert(Vector2 v);
function RL_Vector2Invert( object $v ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Invert( $v ); }

/// Clamp the components of the vector between min and max values specified by the given vectors
// Vector2 Vector2Clamp(Vector2 v , Vector2 min , Vector2 max);
function RL_Vector2Clamp( object $v , object $min , object $max ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Clamp( $v , $min , $max ); }

/// Clamp the magnitude of the vector between two min and max values
// Vector2 Vector2ClampValue(Vector2 v , float min , float max);
function RL_Vector2ClampValue( object $v , float $min , float $max ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2ClampValue( $v , $min , $max ); }

/// Check whether two given vectors are almost equal
// int Vector2Equals(Vector2 p , Vector2 q);
function RL_Vector2Equals( object $p , object $q ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector2Equals( $p , $q ); }

/// Vector with components value 0.0f
// Vector3 Vector3Zero(void);
function RL_Vector3Zero(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Zero(  ); }

/// Vector with components value 1.0f
// Vector3 Vector3One(void);
function RL_Vector3One(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3One(  ); }

/// Add two vectors
// Vector3 Vector3Add(Vector3 v1 , Vector3 v2);
function RL_Vector3Add( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Add( $v1 , $v2 ); }

/// Add vector and float value
// Vector3 Vector3AddValue(Vector3 v , float add);
function RL_Vector3AddValue( object $v , float $add ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3AddValue( $v , $add ); }

/// Subtract two vectors
// Vector3 Vector3Subtract(Vector3 v1 , Vector3 v2);
function RL_Vector3Subtract( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Subtract( $v1 , $v2 ); }

/// Subtract vector by float value
// Vector3 Vector3SubtractValue(Vector3 v , float sub);
function RL_Vector3SubtractValue( object $v , float $sub ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3SubtractValue( $v , $sub ); }

/// Multiply vector by scalar
// Vector3 Vector3Scale(Vector3 v , float scalar);
function RL_Vector3Scale( object $v , float $scalar ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Scale( $v , $scalar ); }

/// Multiply vector by vector
// Vector3 Vector3Multiply(Vector3 v1 , Vector3 v2);
function RL_Vector3Multiply( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Multiply( $v1 , $v2 ); }

/// Calculate two vectors cross product
// Vector3 Vector3CrossProduct(Vector3 v1 , Vector3 v2);
function RL_Vector3CrossProduct( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3CrossProduct( $v1 , $v2 ); }

/// Calculate one vector perpendicular vector
// Vector3 Vector3Perpendicular(Vector3 v);
function RL_Vector3Perpendicular( object $v ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Perpendicular( $v ); }

/// Calculate vector length
// float Vector3Length(const Vector3 v);
function RL_Vector3Length( object $v ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Length( $v ); }

/// Calculate vector square length
// float Vector3LengthSqr(const Vector3 v);
function RL_Vector3LengthSqr( object $v ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3LengthSqr( $v ); }

/// Calculate two vectors dot product
// float Vector3DotProduct(Vector3 v1 , Vector3 v2);
function RL_Vector3DotProduct( object $v1 , object $v2 ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3DotProduct( $v1 , $v2 ); }

/// Calculate distance between two vectors
// float Vector3Distance(Vector3 v1 , Vector3 v2);
function RL_Vector3Distance( object $v1 , object $v2 ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Distance( $v1 , $v2 ); }

/// Calculate square distance between two vectors
// float Vector3DistanceSqr(Vector3 v1 , Vector3 v2);
function RL_Vector3DistanceSqr( object $v1 , object $v2 ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3DistanceSqr( $v1 , $v2 ); }

/// Calculate angle between two vectors
// float Vector3Angle(Vector3 v1 , Vector3 v2);
function RL_Vector3Angle( object $v1 , object $v2 ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Angle( $v1 , $v2 ); }

/// Negate provided vector (invert direction)
// Vector3 Vector3Negate(Vector3 v);
function RL_Vector3Negate( object $v ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Negate( $v ); }

/// Divide vector by vector
// Vector3 Vector3Divide(Vector3 v1 , Vector3 v2);
function RL_Vector3Divide( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Divide( $v1 , $v2 ); }

/// Normalize provided vector
// Vector3 Vector3Normalize(Vector3 v);
function RL_Vector3Normalize( object $v ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Normalize( $v ); }

/// Orthonormalize provided vectors. Makes vectors normalized and orthogonal to each other Gram-Schmidt function implementation
// void Vector3OrthoNormalize(Vector3* v1 , Vector3* v2);
function RL_Vector3OrthoNormalize( object $v1 , object $v2 ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->Vector3OrthoNormalize( $v1 , $v2 ); }

/// Transforms a Vector3 by a given Matrix
// Vector3 Vector3Transform(Vector3 v , Matrix mat);
function RL_Vector3Transform( object $v , object $mat ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Transform( $v , $mat ); }

/// Transform a vector by quaternion rotation
// Vector3 Vector3RotateByQuaternion(Vector3 v , Quaternion q);
function RL_Vector3RotateByQuaternion( object $v , object $q ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3RotateByQuaternion( $v , $q ); }

/// Rotates a vector around an axis
// Vector3 Vector3RotateByAxisAngle(Vector3 v , Vector3 axis , float angle);
function RL_Vector3RotateByAxisAngle( object $v , object $axis , float $angle ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3RotateByAxisAngle( $v , $axis , $angle ); }

/// Calculate linear interpolation between two vectors
// Vector3 Vector3Lerp(Vector3 v1 , Vector3 v2 , float amount);
function RL_Vector3Lerp( object $v1 , object $v2 , float $amount ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Lerp( $v1 , $v2 , $amount ); }

/// Calculate reflected vector to normal
// Vector3 Vector3Reflect(Vector3 v , Vector3 normal);
function RL_Vector3Reflect( object $v , object $normal ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Reflect( $v , $normal ); }

/// Get min value for each pair of components
// Vector3 Vector3Min(Vector3 v1 , Vector3 v2);
function RL_Vector3Min( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Min( $v1 , $v2 ); }

/// Get max value for each pair of components
// Vector3 Vector3Max(Vector3 v1 , Vector3 v2);
function RL_Vector3Max( object $v1 , object $v2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Max( $v1 , $v2 ); }

/// Compute barycenter coordinates (u, v, w) for point p with respect to triangle (a, b, c). NOTE: Assumes P is on the plane of the triangle
// Vector3 Vector3Barycenter(Vector3 p , Vector3 a , Vector3 b , Vector3 c);
function RL_Vector3Barycenter( object $p , object $a , object $b , object $c ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Barycenter( $p , $a , $b , $c ); }

/// Projects a Vector3 from screen space into object space. NOTE: We are avoiding calling other raymath functions despite available
// Vector3 Vector3Unproject(Vector3 source , Matrix projection , Matrix view);
function RL_Vector3Unproject( object $source , object $projection , object $view ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Unproject( $source , $projection , $view ); }

/// Get Vector3 as float array
// float3 Vector3ToFloatV(Vector3 v);
function RL_Vector3ToFloatV( object $v ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3ToFloatV( $v ); }

/// Invert the given vector
// Vector3 Vector3Invert(Vector3 v);
function RL_Vector3Invert( object $v ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Invert( $v ); }

/// Clamp the components of the vector between min and max values specified by the given vectors
// Vector3 Vector3Clamp(Vector3 v , Vector3 min , Vector3 max);
function RL_Vector3Clamp( object $v , object $min , object $max ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Clamp( $v , $min , $max ); }

/// Clamp the magnitude of the vector between two values
// Vector3 Vector3ClampValue(Vector3 v , float min , float max);
function RL_Vector3ClampValue( object $v , float $min , float $max ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3ClampValue( $v , $min , $max ); }

/// Check whether two given vectors are almost equal
// int Vector3Equals(Vector3 p , Vector3 q);
function RL_Vector3Equals( object $p , object $q ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Equals( $p , $q ); }

/// Compute the direction of a refracted ray where v specifies the normalized direction of the incoming ray, n specifies the normalized normal vector of the interface of two optical media, and r specifies the ratio of the refractive index of the medium from where the ray comes to the refractive index of the medium on the other side of the surface
// Vector3 Vector3Refract(Vector3 v , Vector3 n , float r);
function RL_Vector3Refract( object $v , object $n , float $r ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->Vector3Refract( $v , $n , $r ); }

/// Compute matrix determinant
// float MatrixDeterminant(Matrix mat);
function RL_MatrixDeterminant( object $mat ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixDeterminant( $mat ); }

/// Get the trace of the matrix (sum of the values along the diagonal)
// float MatrixTrace(Matrix mat);
function RL_MatrixTrace( object $mat ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixTrace( $mat ); }

/// Transposes provided matrix
// Matrix MatrixTranspose(Matrix mat);
function RL_MatrixTranspose( object $mat ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixTranspose( $mat ); }

/// Invert provided matrix
// Matrix MatrixInvert(Matrix mat);
function RL_MatrixInvert( object $mat ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixInvert( $mat ); }

/// Get identity matrix
// Matrix MatrixIdentity(void);
function RL_MatrixIdentity(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixIdentity(  ); }

/// Add two matrices
// Matrix MatrixAdd(Matrix left , Matrix right);
function RL_MatrixAdd( object $left , object $right ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixAdd( $left , $right ); }

/// Subtract two matrices (left - right)
// Matrix MatrixSubtract(Matrix left , Matrix right);
function RL_MatrixSubtract( object $left , object $right ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixSubtract( $left , $right ); }

/// Get two matrix multiplication. NOTE: When multiplying matrices... the order matters!
// Matrix MatrixMultiply(Matrix left , Matrix right);
function RL_MatrixMultiply( object $left , object $right ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixMultiply( $left , $right ); }

/// Get translation matrix
// Matrix MatrixTranslate(float x , float y , float z);
function RL_MatrixTranslate( float $x , float $y , float $z ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixTranslate( $x , $y , $z ); }

/// Create rotation matrix from axis and angle. NOTE: Angle should be provided in radians
// Matrix MatrixRotate(Vector3 axis , float angle);
function RL_MatrixRotate( object $axis , float $angle ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixRotate( $axis , $angle ); }

/// Get x-rotation matrix. NOTE: Angle must be provided in radians
// Matrix MatrixRotateX(float angle);
function RL_MatrixRotateX( float $angle ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixRotateX( $angle ); }

/// Get y-rotation matrix. NOTE: Angle must be provided in radians
// Matrix MatrixRotateY(float angle);
function RL_MatrixRotateY( float $angle ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixRotateY( $angle ); }

/// Get z-rotation matrix. NOTE: Angle must be provided in radians
// Matrix MatrixRotateZ(float angle);
function RL_MatrixRotateZ( float $angle ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixRotateZ( $angle ); }

/// Get xyz-rotation matrix. NOTE: Angle must be provided in radians
// Matrix MatrixRotateXYZ(Vector3 angle);
function RL_MatrixRotateXYZ( object $angle ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixRotateXYZ( $angle ); }

/// Get zyx-rotation matrix. NOTE: Angle must be provided in radians
// Matrix MatrixRotateZYX(Vector3 angle);
function RL_MatrixRotateZYX( object $angle ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixRotateZYX( $angle ); }

/// Get scaling matrix
// Matrix MatrixScale(float x , float y , float z);
function RL_MatrixScale( float $x , float $y , float $z ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixScale( $x , $y , $z ); }

/// Get perspective projection matrix
// Matrix MatrixFrustum(double left , double right , double bottom , double top , double near , double far);
function RL_MatrixFrustum( float $left , float $right , float $bottom , float $top , float $near , float $far ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixFrustum( $left , $right , $bottom , $top , $near , $far ); }

/// Get perspective projection matrix. NOTE: Fovy angle must be provided in radians
// Matrix MatrixPerspective(double fovy , double aspect , double near , double far);
function RL_MatrixPerspective( float $fovy , float $aspect , float $near , float $far ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixPerspective( $fovy , $aspect , $near , $far ); }

/// Get orthographic projection matrix
// Matrix MatrixOrtho(double left , double right , double bottom , double top , double near , double far);
function RL_MatrixOrtho( float $left , float $right , float $bottom , float $top , float $near , float $far ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixOrtho( $left , $right , $bottom , $top , $near , $far ); }

/// Get camera look-at matrix (view matrix)
// Matrix MatrixLookAt(Vector3 eye , Vector3 target , Vector3 up);
function RL_MatrixLookAt( object $eye , object $target , object $up ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixLookAt( $eye , $target , $up ); }

/// Get float array of matrix data
// float16 MatrixToFloatV(Matrix mat);
function RL_MatrixToFloatV( object $mat ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->MatrixToFloatV( $mat ); }

/// Add two quaternions
// Quaternion QuaternionAdd(Quaternion q1 , Quaternion q2);
function RL_QuaternionAdd( object $q1 , object $q2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionAdd( $q1 , $q2 ); }

/// Add quaternion and float value
// Quaternion QuaternionAddValue(Quaternion q , float add);
function RL_QuaternionAddValue( object $q , float $add ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionAddValue( $q , $add ); }

/// Subtract two quaternions
// Quaternion QuaternionSubtract(Quaternion q1 , Quaternion q2);
function RL_QuaternionSubtract( object $q1 , object $q2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionSubtract( $q1 , $q2 ); }

/// Subtract quaternion and float value
// Quaternion QuaternionSubtractValue(Quaternion q , float sub);
function RL_QuaternionSubtractValue( object $q , float $sub ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionSubtractValue( $q , $sub ); }

/// Get identity quaternion
// Quaternion QuaternionIdentity(void);
function RL_QuaternionIdentity(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionIdentity(  ); }

/// Computes the length of a quaternion
// float QuaternionLength(Quaternion q);
function RL_QuaternionLength( object $q ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionLength( $q ); }

/// Normalize provided quaternion
// Quaternion QuaternionNormalize(Quaternion q);
function RL_QuaternionNormalize( object $q ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionNormalize( $q ); }

/// Invert provided quaternion
// Quaternion QuaternionInvert(Quaternion q);
function RL_QuaternionInvert( object $q ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionInvert( $q ); }

/// Calculate two quaternion multiplication
// Quaternion QuaternionMultiply(Quaternion q1 , Quaternion q2);
function RL_QuaternionMultiply( object $q1 , object $q2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionMultiply( $q1 , $q2 ); }

/// Scale quaternion by float value
// Quaternion QuaternionScale(Quaternion q , float mul);
function RL_QuaternionScale( object $q , float $mul ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionScale( $q , $mul ); }

/// Divide two quaternions
// Quaternion QuaternionDivide(Quaternion q1 , Quaternion q2);
function RL_QuaternionDivide( object $q1 , object $q2 ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionDivide( $q1 , $q2 ); }

/// Calculate linear interpolation between two quaternions
// Quaternion QuaternionLerp(Quaternion q1 , Quaternion q2 , float amount);
function RL_QuaternionLerp( object $q1 , object $q2 , float $amount ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionLerp( $q1 , $q2 , $amount ); }

/// Calculate slerp-optimized interpolation between two quaternions
// Quaternion QuaternionNlerp(Quaternion q1 , Quaternion q2 , float amount);
function RL_QuaternionNlerp( object $q1 , object $q2 , float $amount ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionNlerp( $q1 , $q2 , $amount ); }

/// Calculates spherical linear interpolation between two quaternions
// Quaternion QuaternionSlerp(Quaternion q1 , Quaternion q2 , float amount);
function RL_QuaternionSlerp( object $q1 , object $q2 , float $amount ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionSlerp( $q1 , $q2 , $amount ); }

/// Calculate quaternion based on the rotation from one vector to another
// Quaternion QuaternionFromVector3ToVector3(Vector3 from , Vector3 to);
function RL_QuaternionFromVector3ToVector3( object $from , object $to ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionFromVector3ToVector3( $from , $to ); }

/// Get a quaternion for a given rotation matrix
// Quaternion QuaternionFromMatrix(Matrix mat);
function RL_QuaternionFromMatrix( object $mat ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionFromMatrix( $mat ); }

/// Get a matrix for a given quaternion
// Matrix QuaternionToMatrix(Quaternion q);
function RL_QuaternionToMatrix( object $q ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionToMatrix( $q ); }

/// Get rotation quaternion for an angle and axis. NOTE: Angle must be provided in radians
// Quaternion QuaternionFromAxisAngle(Vector3 axis , float angle);
function RL_QuaternionFromAxisAngle( object $axis , float $angle ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionFromAxisAngle( $axis , $angle ); }

/// Get the rotation angle and axis for a given quaternion
// void QuaternionToAxisAngle(Quaternion q , Vector3* outAxis , float* outAngle);
function RL_QuaternionToAxisAngle( object $q , object $outAxis , object $outAngle ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->QuaternionToAxisAngle( $q , $outAxis , $outAngle ); }

/// Get the quaternion equivalent to Euler angles. NOTE: Rotation order is ZYX
// Quaternion QuaternionFromEuler(float pitch , float yaw , float roll);
function RL_QuaternionFromEuler( float $pitch , float $yaw , float $roll ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionFromEuler( $pitch , $yaw , $roll ); }

/// Get the Euler angles equivalent to quaternion (roll, pitch, yaw). NOTE: Angles are returned in a Vector3 struct in radians
// Vector3 QuaternionToEuler(Quaternion q);
function RL_QuaternionToEuler( object $q ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionToEuler( $q ); }

/// Transform a quaternion given a transformation matrix
// Quaternion QuaternionTransform(Quaternion q , Matrix mat);
function RL_QuaternionTransform( object $q , object $mat ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionTransform( $q , $mat ); }

/// Check whether two given quaternions are almost equal
// int QuaternionEquals(Quaternion p , Quaternion q);
function RL_QuaternionEquals( object $p , object $q ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->QuaternionEquals( $p , $q ); }

/// Choose the current matrix to be transformed
// void rlMatrixMode(int mode);
function RL_rlMatrixMode( int $mode ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlMatrixMode( $mode ); }

/// Push the current matrix to stack
// void rlPushMatrix(void);
function RL_rlPushMatrix(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlPushMatrix(  ); }

/// Pop latest inserted matrix from stack
// void rlPopMatrix(void);
function RL_rlPopMatrix(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlPopMatrix(  ); }

/// Reset current matrix to identity matrix
// void rlLoadIdentity(void);
function RL_rlLoadIdentity(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlLoadIdentity(  ); }

/// Multiply the current matrix by a translation matrix
// void rlTranslatef(float x , float y , float z);
function RL_rlTranslatef( float $x , float $y , float $z ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlTranslatef( $x , $y , $z ); }

/// Multiply the current matrix by a rotation matrix
// void rlRotatef(float angle , float x , float y , float z);
function RL_rlRotatef( float $angle , float $x , float $y , float $z ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlRotatef( $angle , $x , $y , $z ); }

/// Multiply the current matrix by a scaling matrix
// void rlScalef(float x , float y , float z);
function RL_rlScalef( float $x , float $y , float $z ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlScalef( $x , $y , $z ); }

/// Multiply the current matrix by another matrix
// void rlMultMatrixf(const float* matf);
function RL_rlMultMatrixf( object $matf ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlMultMatrixf( $matf ); }

/// //
// void rlFrustum(double left , double right , double bottom , double top , double znear , double zfar);
function RL_rlFrustum( float $left , float $right , float $bottom , float $top , float $znear , float $zfar ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlFrustum( $left , $right , $bottom , $top , $znear , $zfar ); }

/// //
// void rlOrtho(double left , double right , double bottom , double top , double znear , double zfar);
function RL_rlOrtho( float $left , float $right , float $bottom , float $top , float $znear , float $zfar ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlOrtho( $left , $right , $bottom , $top , $znear , $zfar ); }

/// Set the viewport area
// void rlViewport(int x , int y , int width , int height);
function RL_rlViewport( int $x , int $y , int $width , int $height ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlViewport( $x , $y , $width , $height ); }

/// Initialize drawing mode (how to organize vertex)
// void rlBegin(int mode);
function RL_rlBegin( int $mode ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlBegin( $mode ); }

/// Finish vertex providing
// void rlEnd(void);
function RL_rlEnd(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnd(  ); }

/// Define one vertex (position) - 2 int
// void rlVertex2i(int x , int y);
function RL_rlVertex2i( int $x , int $y ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlVertex2i( $x , $y ); }

/// Define one vertex (position) - 2 float
// void rlVertex2f(float x , float y);
function RL_rlVertex2f( float $x , float $y ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlVertex2f( $x , $y ); }

/// Define one vertex (position) - 3 float
// void rlVertex3f(float x , float y , float z);
function RL_rlVertex3f( float $x , float $y , float $z ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlVertex3f( $x , $y , $z ); }

/// Define one vertex (texture coordinate) - 2 float
// void rlTexCoord2f(float x , float y);
function RL_rlTexCoord2f( float $x , float $y ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlTexCoord2f( $x , $y ); }

/// Define one vertex (normal) - 3 float
// void rlNormal3f(float x , float y , float z);
function RL_rlNormal3f( float $x , float $y , float $z ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlNormal3f( $x , $y , $z ); }

/// Define one vertex (color) - 4 byte
// void rlColor4ub(unsigned char r , unsigned char g , unsigned char b , unsigned char a);
function RL_rlColor4ub( int $r , int $g , int $b , int $a ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlColor4ub( $r , $g , $b , $a ); }

/// Define one vertex (color) - 3 float
// void rlColor3f(float x , float y , float z);
function RL_rlColor3f( float $x , float $y , float $z ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlColor3f( $x , $y , $z ); }

/// Define one vertex (color) - 4 float
// void rlColor4f(float x , float y , float z , float w);
function RL_rlColor4f( float $x , float $y , float $z , float $w ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlColor4f( $x , $y , $z , $w ); }

/// Enable vertex array (VAO, if supported)
// bool rlEnableVertexArray(unsigned int vaoId);
function RL_rlEnableVertexArray( int $vaoId ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->rlEnableVertexArray( $vaoId ); }

/// Disable vertex array (VAO, if supported)
// void rlDisableVertexArray(void);
function RL_rlDisableVertexArray(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableVertexArray(  ); }

/// Enable vertex buffer (VBO)
// void rlEnableVertexBuffer(unsigned int id);
function RL_rlEnableVertexBuffer( int $id ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableVertexBuffer( $id ); }

/// Disable vertex buffer (VBO)
// void rlDisableVertexBuffer(void);
function RL_rlDisableVertexBuffer(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableVertexBuffer(  ); }

/// Enable vertex buffer element (VBO element)
// void rlEnableVertexBufferElement(unsigned int id);
function RL_rlEnableVertexBufferElement( int $id ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableVertexBufferElement( $id ); }

/// Disable vertex buffer element (VBO element)
// void rlDisableVertexBufferElement(void);
function RL_rlDisableVertexBufferElement(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableVertexBufferElement(  ); }

/// Enable vertex attribute index
// void rlEnableVertexAttribute(unsigned int index);
function RL_rlEnableVertexAttribute( int $index ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableVertexAttribute( $index ); }

/// Disable vertex attribute index
// void rlDisableVertexAttribute(unsigned int index);
function RL_rlDisableVertexAttribute( int $index ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableVertexAttribute( $index ); }

/// Select and active a texture slot
// void rlActiveTextureSlot(int slot);
function RL_rlActiveTextureSlot( int $slot ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlActiveTextureSlot( $slot ); }

/// Enable texture
// void rlEnableTexture(unsigned int id);
function RL_rlEnableTexture( int $id ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableTexture( $id ); }

/// Disable texture
// void rlDisableTexture(void);
function RL_rlDisableTexture(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableTexture(  ); }

/// Enable texture cubemap
// void rlEnableTextureCubemap(unsigned int id);
function RL_rlEnableTextureCubemap( int $id ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableTextureCubemap( $id ); }

/// Disable texture cubemap
// void rlDisableTextureCubemap(void);
function RL_rlDisableTextureCubemap(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableTextureCubemap(  ); }

/// Set texture parameters (filter, wrap)
// void rlTextureParameters(unsigned int id , int param , int value);
function RL_rlTextureParameters( int $id , int $param , int $value ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlTextureParameters( $id , $param , $value ); }

/// Set cubemap parameters (filter, wrap)
// void rlCubemapParameters(unsigned int id , int param , int value);
function RL_rlCubemapParameters( int $id , int $param , int $value ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlCubemapParameters( $id , $param , $value ); }

/// Enable shader program
// void rlEnableShader(unsigned int id);
function RL_rlEnableShader( int $id ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableShader( $id ); }

/// Disable shader program
// void rlDisableShader(void);
function RL_rlDisableShader(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableShader(  ); }

/// Enable render texture (fbo)
// void rlEnableFramebuffer(unsigned int id);
function RL_rlEnableFramebuffer( int $id ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableFramebuffer( $id ); }

/// Disable render texture (fbo), return to default framebuffer
// void rlDisableFramebuffer(void);
function RL_rlDisableFramebuffer(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableFramebuffer(  ); }

/// Activate multiple draw color buffers
// void rlActiveDrawBuffers(int count);
function RL_rlActiveDrawBuffers( int $count ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlActiveDrawBuffers( $count ); }

/// Enable color blending
// void rlEnableColorBlend(void);
function RL_rlEnableColorBlend(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableColorBlend(  ); }

/// Disable color blending
// void rlDisableColorBlend(void);
function RL_rlDisableColorBlend(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableColorBlend(  ); }

/// Enable depth test
// void rlEnableDepthTest(void);
function RL_rlEnableDepthTest(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableDepthTest(  ); }

/// Disable depth test
// void rlDisableDepthTest(void);
function RL_rlDisableDepthTest(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableDepthTest(  ); }

/// Enable depth write
// void rlEnableDepthMask(void);
function RL_rlEnableDepthMask(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableDepthMask(  ); }

/// Disable depth write
// void rlDisableDepthMask(void);
function RL_rlDisableDepthMask(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableDepthMask(  ); }

/// Enable backface culling
// void rlEnableBackfaceCulling(void);
function RL_rlEnableBackfaceCulling(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableBackfaceCulling(  ); }

/// Disable backface culling
// void rlDisableBackfaceCulling(void);
function RL_rlDisableBackfaceCulling(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableBackfaceCulling(  ); }

/// Set face culling mode
// void rlSetCullFace(int mode);
function RL_rlSetCullFace( int $mode ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetCullFace( $mode ); }

/// Enable scissor test
// void rlEnableScissorTest(void);
function RL_rlEnableScissorTest(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableScissorTest(  ); }

/// Disable scissor test
// void rlDisableScissorTest(void);
function RL_rlDisableScissorTest(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableScissorTest(  ); }

/// Scissor test
// void rlScissor(int x , int y , int width , int height);
function RL_rlScissor( int $x , int $y , int $width , int $height ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlScissor( $x , $y , $width , $height ); }

/// Enable wire mode
// void rlEnableWireMode(void);
function RL_rlEnableWireMode(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableWireMode(  ); }

/// Disable wire mode
// void rlDisableWireMode(void);
function RL_rlDisableWireMode(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableWireMode(  ); }

/// Set the line drawing width
// void rlSetLineWidth(float width);
function RL_rlSetLineWidth( float $width ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetLineWidth( $width ); }

/// Get the line drawing width
// float rlGetLineWidth(void);
function RL_rlGetLineWidth(  ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetLineWidth(  ); }

/// Enable line aliasing
// void rlEnableSmoothLines(void);
function RL_rlEnableSmoothLines(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableSmoothLines(  ); }

/// Disable line aliasing
// void rlDisableSmoothLines(void);
function RL_rlDisableSmoothLines(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableSmoothLines(  ); }

/// Enable stereo rendering
// void rlEnableStereoRender(void);
function RL_rlEnableStereoRender(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlEnableStereoRender(  ); }

/// Disable stereo rendering
// void rlDisableStereoRender(void);
function RL_rlDisableStereoRender(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDisableStereoRender(  ); }

/// Check if stereo render is enabled
// bool rlIsStereoRenderEnabled(void);
function RL_rlIsStereoRenderEnabled(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->rlIsStereoRenderEnabled(  ); }

/// Clear color buffer with color
// void rlClearColor(unsigned char r , unsigned char g , unsigned char b , unsigned char a);
function RL_rlClearColor( int $r , int $g , int $b , int $a ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlClearColor( $r , $g , $b , $a ); }

/// Clear used screen buffers (color and depth)
// void rlClearScreenBuffers(void);
function RL_rlClearScreenBuffers(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlClearScreenBuffers(  ); }

/// Check and log OpenGL error codes
// void rlCheckErrors(void);
function RL_rlCheckErrors(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlCheckErrors(  ); }

/// Set blending mode
// void rlSetBlendMode(int mode);
function RL_rlSetBlendMode( int $mode ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetBlendMode( $mode ); }

/// Set blending mode factor and equation (using OpenGL factors)
// void rlSetBlendFactors(int glSrcFactor , int glDstFactor , int glEquation);
function RL_rlSetBlendFactors( int $glSrcFactor , int $glDstFactor , int $glEquation ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetBlendFactors( $glSrcFactor , $glDstFactor , $glEquation ); }

/// Set blending mode factors and equations separately (using OpenGL factors)
// void rlSetBlendFactorsSeparate(int glSrcRGB , int glDstRGB , int glSrcAlpha , int glDstAlpha , int glEqRGB , int glEqAlpha);
function RL_rlSetBlendFactorsSeparate( int $glSrcRGB , int $glDstRGB , int $glSrcAlpha , int $glDstAlpha , int $glEqRGB , int $glEqAlpha ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetBlendFactorsSeparate( $glSrcRGB , $glDstRGB , $glSrcAlpha , $glDstAlpha , $glEqRGB , $glEqAlpha ); }

/// Initialize rlgl (buffers, shaders, textures, states)
// void rlglInit(int width , int height);
function RL_rlglInit( int $width , int $height ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlglInit( $width , $height ); }

/// De-initialize rlgl (buffers, shaders, textures)
// void rlglClose(void);
function RL_rlglClose(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlglClose(  ); }

/// Load OpenGL extensions (loader function required)
// void rlLoadExtensions(void* loader);
function RL_rlLoadExtensions( object $loader ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlLoadExtensions( $loader ); }

/// Get current OpenGL version
// int rlGetVersion(void);
function RL_rlGetVersion(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetVersion(  ); }

/// Set current framebuffer width
// void rlSetFramebufferWidth(int width);
function RL_rlSetFramebufferWidth( int $width ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetFramebufferWidth( $width ); }

/// Get default framebuffer width
// int rlGetFramebufferWidth(void);
function RL_rlGetFramebufferWidth(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetFramebufferWidth(  ); }

/// Set current framebuffer height
// void rlSetFramebufferHeight(int height);
function RL_rlSetFramebufferHeight( int $height ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetFramebufferHeight( $height ); }

/// Get default framebuffer height
// int rlGetFramebufferHeight(void);
function RL_rlGetFramebufferHeight(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetFramebufferHeight(  ); }

/// Get default texture id
// unsigned int rlGetTextureIdDefault(void);
function RL_rlGetTextureIdDefault(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetTextureIdDefault(  ); }

/// Get default shader id
// unsigned int rlGetShaderIdDefault(void);
function RL_rlGetShaderIdDefault(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetShaderIdDefault(  ); }

/// Get default shader locations
// int* rlGetShaderLocsDefault(void);
function RL_rlGetShaderLocsDefault(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetShaderLocsDefault(  ); }

/// Load a render batch system
// rlRenderBatch rlLoadRenderBatch(int numBuffers , int bufferElements);
function RL_rlLoadRenderBatch( int $numBuffers , int $bufferElements ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadRenderBatch( $numBuffers , $bufferElements ); }

/// Unload render batch system
// void rlUnloadRenderBatch(rlRenderBatch batch);
function RL_rlUnloadRenderBatch( object $batch ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUnloadRenderBatch( $batch ); }

/// Draw render batch data (Update->Draw->Reset)
// void rlDrawRenderBatch(rlRenderBatch* batch);
function RL_rlDrawRenderBatch( object $batch ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDrawRenderBatch( $batch ); }

/// Set the active render batch for rlgl (NULL for default internal)
// void rlSetRenderBatchActive(rlRenderBatch* batch);
function RL_rlSetRenderBatchActive( object $batch ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetRenderBatchActive( $batch ); }

/// Update and draw internal render batch
// void rlDrawRenderBatchActive(void);
function RL_rlDrawRenderBatchActive(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDrawRenderBatchActive(  ); }

/// Check internal buffer overflow for a given number of vertex
// bool rlCheckRenderBatchLimit(int vCount);
function RL_rlCheckRenderBatchLimit( int $vCount ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->rlCheckRenderBatchLimit( $vCount ); }

/// Set current texture for render batch and check buffers limits
// void rlSetTexture(unsigned int id);
function RL_rlSetTexture( int $id ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetTexture( $id ); }

/// Load vertex array (vao) if supported
// unsigned int rlLoadVertexArray(void);
function RL_rlLoadVertexArray(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadVertexArray(  ); }

/// Load a vertex buffer attribute
// unsigned int rlLoadVertexBuffer(const void* buffer , int size , bool dynamic);
function RL_rlLoadVertexBuffer( object $buffer , int $size , bool $dynamic ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadVertexBuffer( $buffer , $size , $dynamic ); }

/// Load a new attributes element buffer
// unsigned int rlLoadVertexBufferElement(const void* buffer , int size , bool dynamic);
function RL_rlLoadVertexBufferElement( object $buffer , int $size , bool $dynamic ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadVertexBufferElement( $buffer , $size , $dynamic ); }

/// Update GPU buffer with new data
// void rlUpdateVertexBuffer(unsigned int bufferId , const void* data , int dataSize , int offset);
function RL_rlUpdateVertexBuffer( int $bufferId , object $data , int $dataSize , int $offset ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUpdateVertexBuffer( $bufferId , $data , $dataSize , $offset ); }

/// Update vertex buffer elements with new data
// void rlUpdateVertexBufferElements(unsigned int id , const void* data , int dataSize , int offset);
function RL_rlUpdateVertexBufferElements( int $id , object $data , int $dataSize , int $offset ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUpdateVertexBufferElements( $id , $data , $dataSize , $offset ); }

/// //
// void rlUnloadVertexArray(unsigned int vaoId);
function RL_rlUnloadVertexArray( int $vaoId ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUnloadVertexArray( $vaoId ); }

/// //
// void rlUnloadVertexBuffer(unsigned int vboId);
function RL_rlUnloadVertexBuffer( int $vboId ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUnloadVertexBuffer( $vboId ); }

/// //
// void rlSetVertexAttribute(unsigned int index , int compSize , int type , bool normalized , int stride , const void* pointer);
function RL_rlSetVertexAttribute( int $index , int $compSize , int $type , bool $normalized , int $stride , object $pointer ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetVertexAttribute( $index , $compSize , $type , $normalized , $stride , $pointer ); }

/// //
// void rlSetVertexAttributeDivisor(unsigned int index , int divisor);
function RL_rlSetVertexAttributeDivisor( int $index , int $divisor ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetVertexAttributeDivisor( $index , $divisor ); }

/// Set vertex attribute default value
// void rlSetVertexAttributeDefault(int locIndex , const void* value , int attribType , int count);
function RL_rlSetVertexAttributeDefault( int $locIndex , object $value , int $attribType , int $count ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetVertexAttributeDefault( $locIndex , $value , $attribType , $count ); }

/// //
// void rlDrawVertexArray(int offset , int count);
function RL_rlDrawVertexArray( int $offset , int $count ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDrawVertexArray( $offset , $count ); }

/// //
// void rlDrawVertexArrayElements(int offset , int count , const void* buffer);
function RL_rlDrawVertexArrayElements( int $offset , int $count , object $buffer ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDrawVertexArrayElements( $offset , $count , $buffer ); }

/// //
// void rlDrawVertexArrayInstanced(int offset , int count , int instances);
function RL_rlDrawVertexArrayInstanced( int $offset , int $count , int $instances ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDrawVertexArrayInstanced( $offset , $count , $instances ); }

/// //
// void rlDrawVertexArrayElementsInstanced(int offset , int count , const void* buffer , int instances);
function RL_rlDrawVertexArrayElementsInstanced( int $offset , int $count , object $buffer , int $instances ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlDrawVertexArrayElementsInstanced( $offset , $count , $buffer , $instances ); }

/// Load texture in GPU
// unsigned int rlLoadTexture(const void* data , int width , int height , int format , int mipmapCount);
function RL_rlLoadTexture( object $data , int $width , int $height , int $format , int $mipmapCount ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadTexture( $data , $width , $height , $format , $mipmapCount ); }

/// Load depth texture/renderbuffer (to be attached to fbo)
// unsigned int rlLoadTextureDepth(int width , int height , bool useRenderBuffer);
function RL_rlLoadTextureDepth( int $width , int $height , bool $useRenderBuffer ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadTextureDepth( $width , $height , $useRenderBuffer ); }

/// Load texture cubemap
// unsigned int rlLoadTextureCubemap(const void* data , int size , int format);
function RL_rlLoadTextureCubemap( object $data , int $size , int $format ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadTextureCubemap( $data , $size , $format ); }

/// Update GPU texture with new data
// void rlUpdateTexture(unsigned int id , int offsetX , int offsetY , int width , int height , int format , const void* data);
function RL_rlUpdateTexture( int $id , int $offsetX , int $offsetY , int $width , int $height , int $format , object $data ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUpdateTexture( $id , $offsetX , $offsetY , $width , $height , $format , $data ); }

/// Get OpenGL internal formats
// void rlGetGlTextureFormats(int format , unsigned int* glInternalFormat , unsigned int* glFormat , unsigned int* glType);
function RL_rlGetGlTextureFormats( int $format , int /*ref:int*/&$glInternalFormat , int /*ref:int*/&$glFormat , int /*ref:int*/&$glType ) : void { global $RAYLIB_FFI; static $__c_ref__glInternalFormat = null ; $__c_ref__glInternalFormat ??= FFI::new("int"); static $__c_ref__glFormat = null ; $__c_ref__glFormat ??= FFI::new("int"); static $__c_ref__glType = null ; $__c_ref__glType ??= FFI::new("int"); $RAYLIB_FFI->rlGetGlTextureFormats( $format , FFI::addr($__c_ref__glInternalFormat) , FFI::addr($__c_ref__glFormat) , FFI::addr($__c_ref__glType) ); $glInternalFormat = $__c_ref__glInternalFormat->cdata ; $glFormat = $__c_ref__glFormat->cdata ; $glType = $__c_ref__glType->cdata ; }

/// Get name string for pixel format
// const char* rlGetPixelFormatName(unsigned int format);
function RL_rlGetPixelFormatName( int $format ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetPixelFormatName( $format ); }

/// Unload texture from GPU memory
// void rlUnloadTexture(unsigned int id);
function RL_rlUnloadTexture( int $id ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUnloadTexture( $id ); }

/// Generate mipmap data for selected texture
// void rlGenTextureMipmaps(unsigned int id , int width , int height , int format , int* mipmaps);
function RL_rlGenTextureMipmaps( int $id , int $width , int $height , int $format , int /*ref:int*/&$mipmaps ) : void { global $RAYLIB_FFI; static $__c_ref__mipmaps = null ; $__c_ref__mipmaps ??= FFI::new("int"); $RAYLIB_FFI->rlGenTextureMipmaps( $id , $width , $height , $format , FFI::addr($__c_ref__mipmaps) ); $mipmaps = $__c_ref__mipmaps->cdata ; }

/// Read texture pixel data
// void* rlReadTexturePixels(unsigned int id , int width , int height , int format);
function RL_rlReadTexturePixels( int $id , int $width , int $height , int $format ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlReadTexturePixels( $id , $width , $height , $format ); }

/// Read screen pixel data (color buffer)
// unsigned char* rlReadScreenPixels(int width , int height);
function RL_rlReadScreenPixels( int $width , int $height ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->rlReadScreenPixels( $width , $height ); }

/// Load an empty framebuffer
// unsigned int rlLoadFramebuffer(int width , int height);
function RL_rlLoadFramebuffer( int $width , int $height ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadFramebuffer( $width , $height ); }

/// Attach texture/renderbuffer to a framebuffer
// void rlFramebufferAttach(unsigned int fboId , unsigned int texId , int attachType , int texType , int mipLevel);
function RL_rlFramebufferAttach( int $fboId , int $texId , int $attachType , int $texType , int $mipLevel ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlFramebufferAttach( $fboId , $texId , $attachType , $texType , $mipLevel ); }

/// Verify framebuffer is complete
// bool rlFramebufferComplete(unsigned int id);
function RL_rlFramebufferComplete( int $id ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->rlFramebufferComplete( $id ); }

/// Delete framebuffer from GPU
// void rlUnloadFramebuffer(unsigned int id);
function RL_rlUnloadFramebuffer( int $id ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUnloadFramebuffer( $id ); }

/// Load shader from code strings
// unsigned int rlLoadShaderCode(const char* vsCode , const char* fsCode);
function RL_rlLoadShaderCode( string $vsCode , string $fsCode ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadShaderCode( $vsCode , $fsCode ); }

/// Compile custom shader and return shader id (type: RL_VERTEX_SHADER, RL_FRAGMENT_SHADER, RL_COMPUTE_SHADER)
// unsigned int rlCompileShader(const char* shaderCode , int type);
function RL_rlCompileShader( string $shaderCode , int $type ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlCompileShader( $shaderCode , $type ); }

/// Load custom shader program
// unsigned int rlLoadShaderProgram(unsigned int vShaderId , unsigned int fShaderId);
function RL_rlLoadShaderProgram( int $vShaderId , int $fShaderId ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadShaderProgram( $vShaderId , $fShaderId ); }

/// Unload shader program
// void rlUnloadShaderProgram(unsigned int id);
function RL_rlUnloadShaderProgram( int $id ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUnloadShaderProgram( $id ); }

/// Get shader location uniform
// int rlGetLocationUniform(unsigned int shaderId , const char* uniformName);
function RL_rlGetLocationUniform( int $shaderId , string $uniformName ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetLocationUniform( $shaderId , $uniformName ); }

/// Get shader location attribute
// int rlGetLocationAttrib(unsigned int shaderId , const char* attribName);
function RL_rlGetLocationAttrib( int $shaderId , string $attribName ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetLocationAttrib( $shaderId , $attribName ); }

/// Set shader value uniform
// void rlSetUniform(int locIndex , const void* value , int uniformType , int count);
function RL_rlSetUniform( int $locIndex , object $value , int $uniformType , int $count ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetUniform( $locIndex , $value , $uniformType , $count ); }

/// Set shader value matrix
// void rlSetUniformMatrix(int locIndex , Matrix mat);
function RL_rlSetUniformMatrix( int $locIndex , object $mat ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetUniformMatrix( $locIndex , $mat ); }

/// Set shader value sampler
// void rlSetUniformSampler(int locIndex , unsigned int textureId);
function RL_rlSetUniformSampler( int $locIndex , int $textureId ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetUniformSampler( $locIndex , $textureId ); }

/// Set shader currently active (id and locations)
// void rlSetShader(unsigned int id , int* locs);
function RL_rlSetShader( int $id , int /*ref:int*/&$locs ) : void { global $RAYLIB_FFI; static $__c_ref__locs = null ; $__c_ref__locs ??= FFI::new("int"); $RAYLIB_FFI->rlSetShader( $id , FFI::addr($__c_ref__locs) ); $locs = $__c_ref__locs->cdata ; }

/// Load compute shader program
// unsigned int rlLoadComputeShaderProgram(unsigned int shaderId);
function RL_rlLoadComputeShaderProgram( int $shaderId ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadComputeShaderProgram( $shaderId ); }

/// Dispatch compute shader (equivalent to *draw* for graphics pipeline)
// void rlComputeShaderDispatch(unsigned int groupX , unsigned int groupY , unsigned int groupZ);
function RL_rlComputeShaderDispatch( int $groupX , int $groupY , int $groupZ ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlComputeShaderDispatch( $groupX , $groupY , $groupZ ); }

/// Load shader storage buffer object (SSBO)
// unsigned int rlLoadShaderBuffer(unsigned int size , const void* data , int usageHint);
function RL_rlLoadShaderBuffer( int $size , object $data , int $usageHint ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlLoadShaderBuffer( $size , $data , $usageHint ); }

/// Unload shader storage buffer object (SSBO)
// void rlUnloadShaderBuffer(unsigned int ssboId);
function RL_rlUnloadShaderBuffer( int $ssboId ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUnloadShaderBuffer( $ssboId ); }

/// Update SSBO buffer data
// void rlUpdateShaderBuffer(unsigned int id , const void* data , unsigned int dataSize , unsigned int offset);
function RL_rlUpdateShaderBuffer( int $id , object $data , int $dataSize , int $offset ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlUpdateShaderBuffer( $id , $data , $dataSize , $offset ); }

/// Bind SSBO buffer
// void rlBindShaderBuffer(unsigned int id , unsigned int index);
function RL_rlBindShaderBuffer( int $id , int $index ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlBindShaderBuffer( $id , $index ); }

/// Read SSBO buffer data (GPU->CPU)
// void rlReadShaderBuffer(unsigned int id , void* dest , unsigned int count , unsigned int offset);
function RL_rlReadShaderBuffer( int $id , object $dest , int $count , int $offset ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlReadShaderBuffer( $id , $dest , $count , $offset ); }

/// Copy SSBO data between buffers
// void rlCopyShaderBuffer(unsigned int destId , unsigned int srcId , unsigned int destOffset , unsigned int srcOffset , unsigned int count);
function RL_rlCopyShaderBuffer( int $destId , int $srcId , int $destOffset , int $srcOffset , int $count ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlCopyShaderBuffer( $destId , $srcId , $destOffset , $srcOffset , $count ); }

/// Get SSBO buffer size
// unsigned int rlGetShaderBufferSize(unsigned int id);
function RL_rlGetShaderBufferSize( int $id ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetShaderBufferSize( $id ); }

/// Bind image texture
// void rlBindImageTexture(unsigned int id , unsigned int index , int format , bool readonly);
function RL_rlBindImageTexture( int $id , int $index , int $format , bool $readonly ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlBindImageTexture( $id , $index , $format , $readonly ); }

/// Get internal modelview matrix
// Matrix rlGetMatrixModelview(void);
function RL_rlGetMatrixModelview(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetMatrixModelview(  ); }

/// Get internal projection matrix
// Matrix rlGetMatrixProjection(void);
function RL_rlGetMatrixProjection(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetMatrixProjection(  ); }

/// Get internal accumulated transform matrix
// Matrix rlGetMatrixTransform(void);
function RL_rlGetMatrixTransform(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetMatrixTransform(  ); }

/// Get internal projection matrix for stereo render (selected eye)
// Matrix rlGetMatrixProjectionStereo(int eye);
function RL_rlGetMatrixProjectionStereo( int $eye ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetMatrixProjectionStereo( $eye ); }

/// Get internal view offset matrix for stereo render (selected eye)
// Matrix rlGetMatrixViewOffsetStereo(int eye);
function RL_rlGetMatrixViewOffsetStereo( int $eye ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->rlGetMatrixViewOffsetStereo( $eye ); }

/// Set a custom projection matrix (replaces internal projection matrix)
// void rlSetMatrixProjection(Matrix proj);
function RL_rlSetMatrixProjection( object $proj ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetMatrixProjection( $proj ); }

/// Set a custom modelview matrix (replaces internal modelview matrix)
// void rlSetMatrixModelview(Matrix view);
function RL_rlSetMatrixModelview( object $view ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetMatrixModelview( $view ); }

/// Set eyes projection matrices for stereo rendering
// void rlSetMatrixProjectionStereo(Matrix right , Matrix left);
function RL_rlSetMatrixProjectionStereo( object $right , object $left ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetMatrixProjectionStereo( $right , $left ); }

/// Set eyes view offsets matrices for stereo rendering
// void rlSetMatrixViewOffsetStereo(Matrix right , Matrix left);
function RL_rlSetMatrixViewOffsetStereo( object $right , object $left ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlSetMatrixViewOffsetStereo( $right , $left ); }

/// Load and draw a cube
// void rlLoadDrawCube(void);
function RL_rlLoadDrawCube(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlLoadDrawCube(  ); }

/// Load and draw a quad
// void rlLoadDrawQuad(void);
function RL_rlLoadDrawQuad(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->rlLoadDrawQuad(  ); }

/// Update camera position for selected mode
// void UpdateCamera(Camera* camera , int mode);
function RL_UpdateCamera( object /*ref*/$camera , int $mode ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UpdateCamera( FFI::addr($camera) , $mode ); }

/// Update camera movement/rotation
// void UpdateCameraPro(Camera* camera , Vector3 movement , Vector3 rotation , float zoom);
function RL_UpdateCameraPro( object /*ref*/$camera , object $movement , object $rotation , float $zoom ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->UpdateCameraPro( FFI::addr($camera) , $movement , $rotation , $zoom ); }

/// //
// Vector3 GetCameraForward(Camera* camera);
function RL_GetCameraForward( object /*ref*/$camera ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCameraForward( FFI::addr($camera) ); }

/// //
// Vector3 GetCameraUp(Camera* camera);
function RL_GetCameraUp( object /*ref*/$camera ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCameraUp( FFI::addr($camera) ); }

/// //
// Vector3 GetCameraRight(Camera* camera);
function RL_GetCameraRight( object /*ref*/$camera ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCameraRight( FFI::addr($camera) ); }

/// //
// void CameraMoveForward(Camera* camera , float distance , bool moveInWorldPlane);
function RL_CameraMoveForward( object /*ref*/$camera , float $distance , bool $moveInWorldPlane ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->CameraMoveForward( FFI::addr($camera) , $distance , $moveInWorldPlane ); }

/// //
// void CameraMoveUp(Camera* camera , float distance);
function RL_CameraMoveUp( object /*ref*/$camera , float $distance ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->CameraMoveUp( FFI::addr($camera) , $distance ); }

/// //
// void CameraMoveRight(Camera* camera , float distance , bool moveInWorldPlane);
function RL_CameraMoveRight( object /*ref*/$camera , float $distance , bool $moveInWorldPlane ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->CameraMoveRight( FFI::addr($camera) , $distance , $moveInWorldPlane ); }

/// //
// void CameraMoveToTarget(Camera* camera , float delta);
function RL_CameraMoveToTarget( object /*ref*/$camera , float $delta ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->CameraMoveToTarget( FFI::addr($camera) , $delta ); }

/// //
// void CameraYaw(Camera* camera , float angle , bool rotateAroundTarget);
function RL_CameraYaw( object /*ref*/$camera , float $angle , bool $rotateAroundTarget ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->CameraYaw( FFI::addr($camera) , $angle , $rotateAroundTarget ); }

/// //
// void CameraPitch(Camera* camera , float angle , bool lockView , bool rotateAroundTarget , bool rotateUp);
function RL_CameraPitch( object /*ref*/$camera , float $angle , bool $lockView , bool $rotateAroundTarget , bool $rotateUp ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->CameraPitch( FFI::addr($camera) , $angle , $lockView , $rotateAroundTarget , $rotateUp ); }

/// //
// void CameraRoll(Camera* camera , float angle);
function RL_CameraRoll( object /*ref*/$camera , float $angle ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->CameraRoll( FFI::addr($camera) , $angle ); }

/// //
// Matrix GetCameraViewMatrix(Camera* camera);
function RL_GetCameraViewMatrix( object /*ref*/$camera ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCameraViewMatrix( FFI::addr($camera) ); }

/// //
// Matrix GetCameraProjectionMatrix(Camera* camera , float aspect);
function RL_GetCameraProjectionMatrix( object /*ref*/$camera , float $aspect ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GetCameraProjectionMatrix( FFI::addr($camera) , $aspect ); }


_RAYLIB_define_colors_when_ready();

if ( RL_SUPPORT_MODULE_RAYGUI ) {

define( 'RAYLIB_FFI_GuiStyleProp' , $RAYLIB_FFI->type( 'GuiStyleProp' ) );
function RL_GuiStyleProp( ...$_ ) : object { $OBJ = FFI::new( RAYLIB_FFI_GuiStyleProp ); $FIELDS = RAYLIB_FFI_GuiStyleProp->getStructFieldNames() ; if ( count( $FIELDS ) == count( $_ ) && isset( $_[0] ) && ! is_array( $_[0] ) ) foreach( $FIELDS as $INDEX => $FIELD ) { $OBJ->$FIELD = $_[$INDEX]; } else foreach( $FIELDS as $FIELD ) { if ( isset( $_[0][$FIELD] ) ) $OBJ->$FIELD = $_[0][$FIELD]; } return $OBJ ; }
function RL_GuiStyleProp_array( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_GuiStyleProp , $DIMENSIONS ) ); return $ARR ; }
function RL_GuiStyleProp_alloc( ...$DIMENSIONS ) : object { $ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_GuiStyleProp , $DIMENSIONS ) , false , true ); return $ARR ; }

/// Enable gui controls (global state)
// void GuiEnable(void);
function RL_GuiEnable(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiEnable(  ); }

/// Disable gui controls (global state)
// void GuiDisable(void);
function RL_GuiDisable(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiDisable(  ); }

/// Lock gui controls (global state)
// void GuiLock(void);
function RL_GuiLock(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiLock(  ); }

/// Unlock gui controls (global state)
// void GuiUnlock(void);
function RL_GuiUnlock(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiUnlock(  ); }

/// Check if gui is locked (global state)
// bool GuiIsLocked(void);
function RL_GuiIsLocked(  ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiIsLocked(  ); }

/// Set gui controls alpha (global state), alpha goes from 0.0f to 1.0f
// void GuiFade(float alpha);
function RL_GuiFade( float $alpha ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiFade( $alpha ); }

/// Set gui state (global state)
// void GuiSetState(int state);
function RL_GuiSetState( int $state ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiSetState( $state ); }

/// Get gui state (global state)
// int GuiGetState(void);
function RL_GuiGetState(  ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiGetState(  ); }

/// Set gui custom font (global state)
// void GuiSetFont(Font font);
function RL_GuiSetFont( object $font ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiSetFont( $font ); }

/// Get gui custom font (global state)
// Font GuiGetFont(void);
function RL_GuiGetFont(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiGetFont(  ); }

/// Set one style property
// void GuiSetStyle(int control , int property , int value);
function RL_GuiSetStyle( int $control , int $property , int $value ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiSetStyle( $control , $property , $value ); }

/// Get one style property
// int GuiGetStyle(int control , int property);
function RL_GuiGetStyle( int $control , int $property ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiGetStyle( $control , $property ); }

/// Window Box control, shows a window that can be closed
// bool GuiWindowBox(Rectangle bounds , const char* title);
function RL_GuiWindowBox( object $bounds , string $title ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiWindowBox( $bounds , $title ); }

/// Group Box control with text name
// void GuiGroupBox(Rectangle bounds , const char* text);
function RL_GuiGroupBox( object $bounds , string $text ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiGroupBox( $bounds , $text ); }

/// Line separator control, could contain text
// void GuiLine(Rectangle bounds , const char* text);
function RL_GuiLine( object $bounds , string $text ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiLine( $bounds , $text ); }

/// Panel control, useful to group controls
// void GuiPanel(Rectangle bounds , const char* text);
function RL_GuiPanel( object $bounds , string $text ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiPanel( $bounds , $text ); }

/// Tab Bar control, returns TAB to be closed or -1
// int GuiTabBar(Rectangle bounds , const char** text , int count , int* active);
function RL_GuiTabBar( object $bounds , object $text , int $count , int /*ref:int*/&$active ) : int { global $RAYLIB_FFI; static $__c_ref__active = null ; $__c_ref__active ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->GuiTabBar( $bounds , $text , $count , FFI::addr($__c_ref__active) ); $active = $__c_ref__active->cdata ; return $__result__; }

/// Scroll Panel control
// Rectangle GuiScrollPanel(Rectangle bounds , const char* text , Rectangle content , Vector2* scroll);
function RL_GuiScrollPanel( object $bounds , string $text , object $content , object $scroll ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiScrollPanel( $bounds , $text , $content , $scroll ); }

/// Label control, shows text
// void GuiLabel(Rectangle bounds , const char* text);
function RL_GuiLabel( object $bounds , string $text ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiLabel( $bounds , $text ); }

/// Button control, returns true when clicked
// bool GuiButton(Rectangle bounds , const char* text);
function RL_GuiButton( object $bounds , string $text ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiButton( $bounds , $text ); }

/// Label button control, show true when clicked
// bool GuiLabelButton(Rectangle bounds , const char* text);
function RL_GuiLabelButton( object $bounds , string $text ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiLabelButton( $bounds , $text ); }

/// Toggle Button control, returns true when active
// bool GuiToggle(Rectangle bounds , const char* text , bool active);
function RL_GuiToggle( object $bounds , string $text , bool $active ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiToggle( $bounds , $text , $active ); }

/// Toggle Group control, returns active toggle index
// int GuiToggleGroup(Rectangle bounds , const char* text , int active);
function RL_GuiToggleGroup( object $bounds , string $text , int $active ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiToggleGroup( $bounds , $text , $active ); }

/// Check Box control, returns true when active
// bool GuiCheckBox(Rectangle bounds , const char* text , bool checked);
function RL_GuiCheckBox( object $bounds , string $text , bool $checked ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiCheckBox( $bounds , $text , $checked ); }

/// Combo Box control, returns selected item index
// int GuiComboBox(Rectangle bounds , const char* text , int active);
function RL_GuiComboBox( object $bounds , string $text , int $active ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiComboBox( $bounds , $text , $active ); }

/// Dropdown Box control, returns selected item
// bool GuiDropdownBox(Rectangle bounds , const char* text , int* active , bool editMode);
function RL_GuiDropdownBox( object $bounds , string $text , int /*ref:int*/&$active , bool $editMode ) : bool { global $RAYLIB_FFI; static $__c_ref__active = null ; $__c_ref__active ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->GuiDropdownBox( $bounds , $text , FFI::addr($__c_ref__active) , $editMode ); $active = $__c_ref__active->cdata ; return $__result__; }

/// Spinner control, returns selected value
// bool GuiSpinner(Rectangle bounds , const char* text , int* value , int minValue , int maxValue , bool editMode);
function RL_GuiSpinner( object $bounds , string $text , int /*ref:int*/&$value , int $minValue , int $maxValue , bool $editMode ) : bool { global $RAYLIB_FFI; static $__c_ref__value = null ; $__c_ref__value ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->GuiSpinner( $bounds , $text , FFI::addr($__c_ref__value) , $minValue , $maxValue , $editMode ); $value = $__c_ref__value->cdata ; return $__result__; }

/// Value Box control, updates input text with numbers
// bool GuiValueBox(Rectangle bounds , const char* text , int* value , int minValue , int maxValue , bool editMode);
function RL_GuiValueBox( object $bounds , string $text , int /*ref:int*/&$value , int $minValue , int $maxValue , bool $editMode ) : bool { global $RAYLIB_FFI; static $__c_ref__value = null ; $__c_ref__value ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->GuiValueBox( $bounds , $text , FFI::addr($__c_ref__value) , $minValue , $maxValue , $editMode ); $value = $__c_ref__value->cdata ; return $__result__; }

/// Text Box control, updates input text
// bool GuiTextBox(Rectangle bounds , char* text , int textSize , bool editMode);
function RL_GuiTextBox( object $bounds , string $text , int $textSize , bool $editMode ) : bool { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiTextBox( $bounds , $text , $textSize , $editMode ); }

/// Slider control, returns selected value
// float GuiSlider(Rectangle bounds , const char* textLeft , const char* textRight , float value , float minValue , float maxValue);
function RL_GuiSlider( object $bounds , string $textLeft , string $textRight , float $value , float $minValue , float $maxValue ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiSlider( $bounds , $textLeft , $textRight , $value , $minValue , $maxValue ); }

/// Slider Bar control, returns selected value
// float GuiSliderBar(Rectangle bounds , const char* textLeft , const char* textRight , float value , float minValue , float maxValue);
function RL_GuiSliderBar( object $bounds , string $textLeft , string $textRight , float $value , float $minValue , float $maxValue ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiSliderBar( $bounds , $textLeft , $textRight , $value , $minValue , $maxValue ); }

/// Progress Bar control, shows current progress value
// float GuiProgressBar(Rectangle bounds , const char* textLeft , const char* textRight , float value , float minValue , float maxValue);
function RL_GuiProgressBar( object $bounds , string $textLeft , string $textRight , float $value , float $minValue , float $maxValue ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiProgressBar( $bounds , $textLeft , $textRight , $value , $minValue , $maxValue ); }

/// Status Bar control, shows info text
// void GuiStatusBar(Rectangle bounds , const char* text);
function RL_GuiStatusBar( object $bounds , string $text ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiStatusBar( $bounds , $text ); }

/// Dummy control for placeholders
// void GuiDummyRec(Rectangle bounds , const char* text);
function RL_GuiDummyRec( object $bounds , string $text ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiDummyRec( $bounds , $text ); }

/// Grid control, returns mouse cell position
// Vector2 GuiGrid(Rectangle bounds , const char* text , float spacing , int subdivs);
function RL_GuiGrid( object $bounds , string $text , float $spacing , int $subdivs ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiGrid( $bounds , $text , $spacing , $subdivs ); }

/// List View control, returns selected list item index
// int GuiListView(Rectangle bounds , const char* text , int* scrollIndex , int active);
function RL_GuiListView( object $bounds , string $text , int /*ref:int*/&$scrollIndex , int $active ) : int { global $RAYLIB_FFI; static $__c_ref__scrollIndex = null ; $__c_ref__scrollIndex ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->GuiListView( $bounds , $text , FFI::addr($__c_ref__scrollIndex) , $active ); $scrollIndex = $__c_ref__scrollIndex->cdata ; return $__result__; }

/// List View with extended parameters
// int GuiListViewEx(Rectangle bounds , const char** text , int count , int* focus , int* scrollIndex , int active);
function RL_GuiListViewEx( object $bounds , object $text , int $count , int /*ref:int*/&$focus , int /*ref:int*/&$scrollIndex , int $active ) : int { global $RAYLIB_FFI; static $__c_ref__focus = null ; $__c_ref__focus ??= FFI::new("int"); static $__c_ref__scrollIndex = null ; $__c_ref__scrollIndex ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->GuiListViewEx( $bounds , $text , $count , FFI::addr($__c_ref__focus) , FFI::addr($__c_ref__scrollIndex) , $active ); $focus = $__c_ref__focus->cdata ; $scrollIndex = $__c_ref__scrollIndex->cdata ; return $__result__; }

/// Message Box control, displays a message
// int GuiMessageBox(Rectangle bounds , const char* title , const char* message , const char* buttons);
function RL_GuiMessageBox( object $bounds , string $title , string $message , string $buttons ) : int { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiMessageBox( $bounds , $title , $message , $buttons ); }

/// Text Input Box control, ask for text, supports secret
// int GuiTextInputBox(Rectangle bounds , const char* title , const char* message , const char* buttons , char* text , int textMaxSize , int* secretViewActive);
function RL_GuiTextInputBox( object $bounds , string $title , string $message , string $buttons , string $text , int $textMaxSize , int /*ref:int*/&$secretViewActive ) : int { global $RAYLIB_FFI; static $__c_ref__secretViewActive = null ; $__c_ref__secretViewActive ??= FFI::new("int"); $__result__ = $RAYLIB_FFI->GuiTextInputBox( $bounds , $title , $message , $buttons , $text , $textMaxSize , FFI::addr($__c_ref__secretViewActive) ); $secretViewActive = $__c_ref__secretViewActive->cdata ; return $__result__; }

/// Color Picker control (multiple color controls)
// Color GuiColorPicker(Rectangle bounds , const char* text , Color color);
function RL_GuiColorPicker( object $bounds , string $text , object $color ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiColorPicker( $bounds , $text , $color ); }

/// Color Panel control
// Color GuiColorPanel(Rectangle bounds , const char* text , Color color);
function RL_GuiColorPanel( object $bounds , string $text , object $color ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiColorPanel( $bounds , $text , $color ); }

/// Color Bar Alpha control
// float GuiColorBarAlpha(Rectangle bounds , const char* text , float alpha);
function RL_GuiColorBarAlpha( object $bounds , string $text , float $alpha ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiColorBarAlpha( $bounds , $text , $alpha ); }

/// Color Bar Hue control
// float GuiColorBarHue(Rectangle bounds , const char* text , float value);
function RL_GuiColorBarHue( object $bounds , string $text , float $value ) : float { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiColorBarHue( $bounds , $text , $value ); }

/// Load style file over global style variable (.rgs)
// void GuiLoadStyle(const char* fileName);
function RL_GuiLoadStyle( string $fileName ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiLoadStyle( $fileName ); }

/// Load style default over global style
// void GuiLoadStyleDefault(void);
function RL_GuiLoadStyleDefault(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiLoadStyleDefault(  ); }

/// Enable gui tooltips (global state)
// void GuiEnableTooltip(void);
function RL_GuiEnableTooltip(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiEnableTooltip(  ); }

/// Disable gui tooltips (global state)
// void GuiDisableTooltip(void);
function RL_GuiDisableTooltip(  ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiDisableTooltip(  ); }

/// Set tooltip string
// void GuiSetTooltip(const char* tooltip);
function RL_GuiSetTooltip( string $tooltip ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiSetTooltip( $tooltip ); }

/// Get text with icon id prepended (if supported)
// const char* GuiIconText(int iconId , const char* text);
function RL_GuiIconText( int $iconId , string $text ) : string { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiIconText( $iconId , $text ); }

/// Set default icon drawing size
// void GuiSetIconScale(int scale);
function RL_GuiSetIconScale( int $scale ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiSetIconScale( $scale ); }

/// Get raygui icons data pointer
// unsigned int* GuiGetIcons(void);
function RL_GuiGetIcons(  ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiGetIcons(  ); }

/// Load raygui icons file (.rgi) into internal icons data
// char** GuiLoadIcons(const char* fileName , bool loadIconsName);
function RL_GuiLoadIcons( string $fileName , bool $loadIconsName ) : object { global $RAYLIB_FFI; return $RAYLIB_FFI->GuiLoadIcons( $fileName , $loadIconsName ); }

/// Draw icon using pixel size at specified position
// void GuiDrawIcon(int iconId , int posX , int posY , int pixelSize , Color color);
function RL_GuiDrawIcon( int $iconId , int $posX , int $posY , int $pixelSize , object $color ) : void { global $RAYLIB_FFI; $RAYLIB_FFI->GuiDrawIcon( $iconId , $posX , $posY , $pixelSize , $color ); }


} // endif RL_SUPPORT_MODULE_RAYGUI

//-------------------------------[/RLAPI_WRAPPER_AUTOGENERATED]--------------------------------

} #endif // RAYLIB_H

//---------------------------------------------------------------------------------------------
// This tool function automatically rebuilds the base of the PHP wrapper for the RLAPI.
//
// ( I could have used Raylib's header parser (https://github.com/raysan5/raylib/tree/master/parser) to generate it
// instead of wasting time and energy implementing this ugly function, but I noticed Raylib's parser too late ...)
//
function _RAYLIB_REBUILD_WRAPPER_FROM_SCRATCH( string $RAYLIB_H , array $BLACKLISTED_FUNCTIONS ) : string
{
	$RLAPI_PHP = '';

	// Typedef list :

	preg_match_all( '|typedef\h+struct\h+(\H+)\h+{|' , $RAYLIB_H , $RAYLIB_FFI_TYPDEF_LIST );
//	print_r( $RAYLIB_FFI_TYPDEF_LIST );

	foreach( $RAYLIB_FFI_TYPDEF_LIST[1] as $TYPE_NAME )
	{
		$RLAPI_PHP .= "define( 'RAYLIB_FFI_$TYPE_NAME' , \$RAYLIB_FFI->type( '$TYPE_NAME' ) );".PHP_EOL ;

		$RLAPI_PHP .= "function RL_$TYPE_NAME( ...\$_ ) : object { \$OBJ = FFI::new( RAYLIB_FFI_$TYPE_NAME ); \$FIELDS = RAYLIB_FFI_{$TYPE_NAME}->getStructFieldNames() ; if ( count( \$FIELDS ) == count( \$_ ) && isset( \$_[0] ) && ! is_array( \$_[0] ) ) foreach( \$FIELDS as \$INDEX => \$FIELD ) { \$OBJ->\$FIELD = \$_[\$INDEX]; } else foreach( \$FIELDS as \$FIELD ) { if ( isset( \$_[0][\$FIELD] ) ) \$OBJ->\$FIELD = \$_[0][\$FIELD]; } return \$OBJ ; }".PHP_EOL;

		$RLAPI_PHP .= "function RL_{$TYPE_NAME}_array( ...\$DIMENSIONS ) : object { \$ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_$TYPE_NAME , \$DIMENSIONS ) ); return \$ARR ; }".PHP_EOL;

		$RLAPI_PHP .= "function RL_{$TYPE_NAME}_alloc( ...\$DIMENSIONS ) : object { \$ARR = FFI::new( FFI::arrayType( RAYLIB_FFI_$TYPE_NAME , \$DIMENSIONS ) , false , true ); return \$ARR ; }".PHP_EOL;

		$RLAPI_PHP .= PHP_EOL ;
	}

//return $RLAPI_PHP ;

	// Function list :

	preg_match_all( '@/\*R.+API\*/\h+(.*;.*)@' , $RAYLIB_H , $MATCHES , PREG_SET_ORDER );

	//print_r( $MATCHES );



	//$RETURN_TYPES = [];

	foreach( $MATCHES as $FOO )
	{
		$FOO = explode( '//' , $FOO[1] );

		if ( count( $FOO ) == 1 ) $FOO[] = '// ' ;

		list( $DEF , $DESC ) = $FOO ;

		$DEF  = trim( $DEF  );
		$DESC = trim( $DESC );

		$DEF = preg_replace( '|\h+\*\*|' , '** '   , $DEF );
		$DEF = preg_replace( '|\h+\*|'   , '* '    , $DEF );
		$DEF = preg_replace( '|(\H),|'   , '$1 , ' , $DEF );
		$DEF = preg_replace( '|\h+|'     , ' '     , $DEF );


		preg_match( '|^(?<type>.+?)\h+(?<name>\H+)\((?<args>.*)\);|' , $DEF , $PARTS );


		$NAME =     $PARTS['name'];
		$ARGS = ' '.$PARTS['args'].' ';
		$TYPE =     $PARTS['type'];

		$ARGS = str_replace( ' void '            , ''          , $ARGS );
		$ARGS = str_replace( ' const '           , ' '         , $ARGS );

		$ARGS = str_replace( ' void* '           , ' object $' , $ARGS );

		$ARGS = str_replace( ' int '             , ' int $'    , $ARGS );
		$ARGS = str_replace( ' int* '            , ' int /*ref:int*/&$'   , $ARGS );
		$ARGS = str_replace( ' unsigned int '    , ' int '     , $ARGS );

		$ARGS = str_replace( ' unsigned char* '  , ' string $' , $ARGS );
		$ARGS = str_replace( ' unsigned char '   , ' int $'    , $ARGS );
		$ARGS = str_replace( ' char* '           , ' string $' , $ARGS );
		$ARGS = str_replace( ' char** '          , ' object $' , $ARGS );
		$ARGS = str_replace( ' char '            , ' string $' , $ARGS );

		$ARGS = str_replace( ' float '           , ' float $'  , $ARGS );
		$ARGS = str_replace( ' float* '          , ' object $' , $ARGS );

		$ARGS = str_replace( ' double '          , ' float $'  , $ARGS );

		$ARGS = str_replace( ' bool '            , ' bool $'   , $ARGS );

		$ARGS = str_replace( ' ... '             , ' ...$_'    , $ARGS );

		$ARGS = str_replace( ' AudioStream '     , ' object $' , $ARGS );
		$ARGS = str_replace( ' BoundingBox '     , ' object $' , $ARGS );
		$ARGS = str_replace( ' Camera '          , ' object $' , $ARGS );
		$ARGS = str_replace( ' Camera* '         , ' object /*ref*/$' , $ARGS );
		$ARGS = str_replace( ' Camera2D '        , ' object $' , $ARGS );
		$ARGS = str_replace( ' Camera3D '        , ' object $' , $ARGS );
		$ARGS = str_replace( ' Color* '          , ' object /*c_array*/$' , $ARGS );
		$ARGS = str_replace( ' Color '           , ' object $' , $ARGS );
		$ARGS = str_replace( ' Font '            , ' object $' , $ARGS );
		$ARGS = str_replace( ' FilePathList '    , ' object $' , $ARGS );
		$ARGS = str_replace( ' GlyphInfo '       , ' object $' , $ARGS );
		$ARGS = str_replace( ' GlyphInfo* '      , ' object $' , $ARGS );
		$ARGS = str_replace( ' Image* '          , ' object /*ref*/$' , $ARGS );
		$ARGS = str_replace( ' Image '           , ' object $' , $ARGS );
		$ARGS = str_replace( ' Material '        , ' object $' , $ARGS );
		$ARGS = str_replace( ' Material* '       , ' object /*ref*/$' , $ARGS );
		$ARGS = str_replace( ' Matrix '          , ' object $' , $ARGS );
		$ARGS = str_replace( ' Matrix* '         , ' object $' , $ARGS );
		$ARGS = str_replace( ' Mesh '            , ' object $' , $ARGS );
		$ARGS = str_replace( ' Mesh* '           , ' object /*ref*/$' , $ARGS );
		$ARGS = str_replace( ' Model '           , ' object $' , $ARGS );
		$ARGS = str_replace( ' Model* '          , ' object $' , $ARGS );
		$ARGS = str_replace( ' ModelAnimation '  , ' object $' , $ARGS );
		$ARGS = str_replace( ' ModelAnimation* ' , ' object $' , $ARGS );
		$ARGS = str_replace( ' Music '           , ' object $' , $ARGS );
		$ARGS = str_replace( ' NPatchInfo '      , ' object $' , $ARGS );
		$ARGS = str_replace( ' Quaternion '      , ' object $' , $ARGS );
		$ARGS = str_replace( ' Ray '             , ' object $' , $ARGS );
		$ARGS = str_replace( ' Rectangle '       , ' object $' , $ARGS );
		$ARGS = str_replace( ' Rectangle** '     , ' object $' , $ARGS );
		$ARGS = str_replace( ' RenderTexture2D ' , ' object $' , $ARGS );
		$ARGS = str_replace( ' Shader '          , ' object $' , $ARGS );
		$ARGS = str_replace( ' Sound '           , ' object $' , $ARGS );
		$ARGS = str_replace( ' Texture2D '       , ' object $' , $ARGS );
		$ARGS = str_replace( ' Texture2D* '      , ' object /*ref*/$' , $ARGS );
		$ARGS = str_replace( ' Vector2 '         , ' object $' , $ARGS );
		$ARGS = str_replace( ' Vector2* '        , ' object $' , $ARGS );
		$ARGS = str_replace( ' Vector3 '         , ' object $' , $ARGS );
		$ARGS = str_replace( ' Vector3* '        , ' object $' , $ARGS );
		$ARGS = str_replace( ' Vector4 '         , ' object $' , $ARGS );
		$ARGS = str_replace( ' VrDeviceInfo '    , ' object $' , $ARGS );
		$ARGS = str_replace( ' VrStereoConfig '  , ' object $' , $ARGS );
		$ARGS = str_replace( ' Wave '            , ' object $' , $ARGS );
		$ARGS = str_replace( ' Wave* '           , ' object $' , $ARGS );
		$ARGS = str_replace( ' rlDrawCall '      , ' object $' , $ARGS );
		$ARGS = str_replace( ' rlRenderBatch '   , ' object $' , $ARGS );
		$ARGS = str_replace( ' rlVertexBuffer '  , ' object $' , $ARGS );
		$ARGS = str_replace( ' rlDrawCall* '     , ' object $' , $ARGS );
		$ARGS = str_replace( ' rlRenderBatch* '  , ' object $' , $ARGS );
		$ARGS = str_replace( ' rlVertexBuffer* ' , ' object $' , $ARGS );

		$ARGS = trim( $ARGS );


		$TYPE = str_replace( 'unsigned char*' , 'string' , $TYPE );
		$TYPE = str_replace( 'const char*'    , 'string' , $TYPE );
		$TYPE = str_replace( 'char*'          , 'string' , $TYPE );
		$TYPE = str_replace( 'void*'          , 'object' , $TYPE );
		$TYPE = str_replace( 'long'           , 'int'    , $TYPE );

		if ( ! in_array( $TYPE , [ 'void' , 'bool' , 'int' , 'float' , 'string' , 'array' , 'object' ]) )
		{
			switch( $TYPE )
			{
				case 'double' : $TYPE = 'float' ; break ;
				default:
					$TYPE = 'object' ;
			}
		}

		$RETURN_REF_ARGS = [];

		if ( empty( $ARGS ) )
		{
			$VARS = '';
		}
		else
		{
			$VARS = explode( ' ' , $ARGS ) ;

				$VARS = array_filter( $VARS , function( $TOK ) { return $TOK == ',' || $TOK[0] == '$' || $TOK[0] == '&' || $TOK[0] == '.' || $TOK[0] == '/'; } );

				foreach( $VARS as &$VAR )
				{
					if ( str_starts_with( $VAR , '/*ref:' ) ) // var ref
					{
						list( $REF_TYPE , $REF_NAME ) = explode( '*/&$' , substr( $VAR , 6 ) );
						$RETURN_REF_ARGS[ $REF_NAME ] = $REF_TYPE ;
						$VAR = 'FFI::addr($__c_ref__'.$REF_NAME.')';
					}
				}

			$VARS = implode( ' ' , $VARS );

			$VARS = preg_replace( '|/\*ref\*/(\$\H+)|' , 'FFI::addr($1)' , $VARS ); // object ref
			//$VARS = str_replace( '&' , '' , $VARS );
		}

		$INNER  = 'global $RAYLIB_FFI;';

		if ( count( $RETURN_REF_ARGS ) == 0 )
		{
			$INNER .= $TYPE != 'void' ? ' return' : '' ;
			$INNER .= ' $RAYLIB_FFI->'.$NAME.'( '.$VARS.' );' ;
		}
		else
		{
			foreach( $RETURN_REF_ARGS as $REF_NAME => $REF_TYPE )
			{
				$INNER .= ' static $__c_ref__'.$REF_NAME.' = null ; $__c_ref__'.$REF_NAME.' ??= FFI::new("'.$REF_TYPE.'");';
			}

			$INNER .= $TYPE != 'void' ? ' $__result__ =' : '' ;
			$INNER .= ' $RAYLIB_FFI->'.$NAME.'( '.$VARS.' );' ;

			foreach( $RETURN_REF_ARGS as $REF_NAME => $REF_TYPE )
			{
				$INNER .= ' $'.$REF_NAME.' = $__c_ref__'.$REF_NAME.'->cdata ;';
			}

			$INNER .= $TYPE != 'void' ? ' return $__result__;' : '' ;
		}

		$LINE = "function RL_$NAME( $ARGS ) : $TYPE { $INNER }";

		if ( in_array( $NAME , $BLACKLISTED_FUNCTIONS ) )
		{
			$LINE = '//XXX '.$LINE ;
		}

		$CODE = '// '.$DEF ;
		$DESC = '/// '.$DESC ;

		$RLAPI_PHP .= $DESC.PHP_EOL.$CODE.PHP_EOL.$LINE.PHP_EOL.PHP_EOL;
	}

	return $RLAPI_PHP ;
}

//---------- Command line utility mode ----------------------------



if ( $_WRAPPER_SCRIPT_RUNNING_IN_UTILITY_MODE_87987987 )
{
	echo "Running ".$argv[0]." as utility ...".PHP_EOL;

	if ( in_array( 'rebuild' , $argv ) )
	{
		echo "Rebuilding ...".PHP_EOL;

		$SOURCE = file_get_contents( $argv[0] );

		$HEAD_PART = substr( $SOURCE , 0 , strpos( $SOURCE , '[RLAPI_WRAPPER_AUTOGENERATED]' ) );
		$TAIL_PART = substr( $SOURCE , strpos( $SOURCE , '[/RLAPI_WRAPPER_AUTOGENERATED]' ) );

		$SOURCE = $HEAD_PART
			. '[RLAPI_WRAPPER_AUTOGENERATED]---------------------------------'.PHP_EOL.PHP_EOL
			. _RAYLIB_REBUILD_WRAPPER_FROM_SCRATCH( $RAYLIB_H , $RLAPI_BLACKLISTED_FUNCTIONS ).PHP_EOL
			. '_RAYLIB_define_colors_when_ready();'.PHP_EOL.PHP_EOL
			. 'if ( RL_SUPPORT_MODULE_RAYGUI ) {'.PHP_EOL.PHP_EOL
			. _RAYLIB_REBUILD_WRAPPER_FROM_SCRATCH( $RAYGUI_H , $RLAPI_BLACKLISTED_FUNCTIONS ).PHP_EOL
			. '} // endif RL_SUPPORT_MODULE_RAYGUI'.PHP_EOL.PHP_EOL
			. '//-------------------------------'
			.$TAIL_PART
			;

		copy( $argv[0] , $argv[0].'.old' );
		file_put_contents( $argv[0] , $SOURCE );

		echo "DONE".PHP_EOL;
	}
	else
	{
		echo "Usage : $argv[0] rebuild".PHP_EOL;
		echo "\tRebuild the automated part of the wrapper.".PHP_EOL;
	}

}

//EOF
