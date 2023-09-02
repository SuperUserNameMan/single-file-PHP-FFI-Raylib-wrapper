<?php
//TAB=4

include('./raylib/raylib.ffi.php');


if ( defined( 'RL_PLATFORM_DESKTOP' ) )
{
	define( 'GLSL_VERSION' ,    330 );
}
else
{   // PLATFORM_RPI, PLATFORM_ANDROID, PLATFORM_WEB
	define( 'GLSL_VERSION' ,    100 );
}

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

// NOTE: screenWidth/screenHeight should match VR device aspect ratio
RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - vr simulator" );

// VR device parameters definition
$DEVICE = RL_VrDeviceInfo();
// Oculus Rift CV1 parameters for simulator
$DEVICE->hResolution = 2160 ;
$DEVICE->vResolution = 1200 ;
$DEVICE->hScreenSize = 0.133793 ;         // Horizontal size in meters
$DEVICE->vScreenSize = 0.0669 ;           // Vertical size in meters
$DEVICE->vScreenCenter = 0.04678 ;        // Screen center in meters
$DEVICE->eyeToScreenDistance = 0.041 ;    // Distance between eye and display in meters
$DEVICE->lensSeparationDistance = 0.07 ;  // Lens separation distance in meters
$DEVICE->interpupillaryDistance = 0.07 ;  // IPD (distance between pupils) in meters
// NOTE: CV1 uses fresnel-hybrid-asymmetric lenses with specific compute shaders
// Following parameters are just an approximation to CV1 distortion stereo rendering
$DEVICE->lensDistortionValues[0] = 1.0 ;  // Lens distortion constant parameter 0
$DEVICE->lensDistortionValues[1] = 0.22 ; // Lens distortion constant parameter 1
$DEVICE->lensDistortionValues[2] = 0.24 ; // Lens distortion constant parameter 2
$DEVICE->lensDistortionValues[3] = 0.0 ;  // Lens distortion constant parameter 3
$DEVICE->chromaAbCorrection[0] = 0.996 ;  // Chromatic aberration correction parameter 0
$DEVICE->chromaAbCorrection[1] = -0.004 ; // Chromatic aberration correction parameter 1
$DEVICE->chromaAbCorrection[2] = 1.014 ;  // Chromatic aberration correction parameter 2
$DEVICE->chromaAbCorrection[3] = 0.0 ;    // Chromatic aberration correction parameter 3


// Load VR stereo config for VR device parameteres (Oculus Rift CV1 parameters)
$CONFIG = RL_LoadVrStereoConfig( $DEVICE );

// Distortion shader (uses device lens distortion and chroma)
$DISTORTION = RL_LoadShader( 0 , RL_TextFormat( "./raylib/examples/resources/distortion%i.fs" , (int)GLSL_VERSION ) );

// Update distortion shader with lens and distortion-scale parameters
RL_SetShaderValue( $DISTORTION , RL_GetShaderLocation( $DISTORTION , "leftLensCenter"   ) , $CONFIG->leftLensCenter   , RL_SHADER_UNIFORM_VEC2 );
RL_SetShaderValue( $DISTORTION , RL_GetShaderLocation( $DISTORTION , "rightLensCenter"  ) , $CONFIG->rightLensCenter  , RL_SHADER_UNIFORM_VEC2 );
RL_SetShaderValue( $DISTORTION , RL_GetShaderLocation( $DISTORTION , "leftScreenCenter" ) , $CONFIG->leftScreenCenter , RL_SHADER_UNIFORM_VEC2 );
RL_SetShaderValue( $DISTORTION , RL_GetShaderLocation( $DISTORTION , "rightScreenCenter") , $CONFIG->rightScreenCenter, RL_SHADER_UNIFORM_VEC2 );
RL_SetShaderValue( $DISTORTION , RL_GetShaderLocation( $DISTORTION , "scale"            ) , $CONFIG->scale            , RL_SHADER_UNIFORM_VEC2 );
RL_SetShaderValue( $DISTORTION , RL_GetShaderLocation( $DISTORTION , "scaleIn"          ) , $CONFIG->scaleIn          , RL_SHADER_UNIFORM_VEC2 );

RL_SetShaderValue( $DISTORTION , RL_GetShaderLocation( $DISTORTION , "deviceWarpParam"  ) , $DEVICE->lensDistortionValues , RL_SHADER_UNIFORM_VEC4 );
RL_SetShaderValue( $DISTORTION , RL_GetShaderLocation( $DISTORTION , "chromaAbParam"    ) , $DEVICE->chromaAbCorrection   , RL_SHADER_UNIFORM_VEC4 );

// Initialize framebuffer for stereo rendering
// NOTE: Screen size should match HMD aspect ratio
$TARGET = RL_LoadRenderTexture( $DEVICE->hResolution , $DEVICE->vResolution );

// The target's height is flipped (in the source Rectangle), due to OpenGL reasons
$SRC_RECT = RL_Rectangle( 0.0 , 0.0 , $TARGET->texture->width , -$TARGET->texture->height );
$DST_RECT = RL_Rectangle( 0.0 , 0.0 , RL_GetScreenWidth() , RL_GetScreenHeight() );

// Define the camera to look into our 3d world
$CAMERA = RL_Camera3D( 0 );
$CAMERA->position   = RL_Vector3( 5.0 , 2.0 , 5.0 );
$CAMERA->target     = RL_Vector3( 0.0 , 2.0 , 0.0 );
$CAMERA->up         = RL_Vector3( 0.0 , 1.0 , 0.0 );
$CAMERA->fovy       = 60.0 ;
$CAMERA->projection = RL_CAMERA_PERSPECTIVE ;

$CUBE_POSITION = RL_Vector3( 0.0 , 0.0 , 0.0 );

RL_DisableCursor();

RL_SetTargetFPS( 90 );

while( ! RL_WindowShouldClose() )
{
	RL_UpdateCamera( $CAMERA , RL_CAMERA_FIRST_PERSON );


	RL_BeginTextureMode( $TARGET );
		RL_ClearBackground( RL_RAYWHITE );
		RL_BeginVrStereoMode( $CONFIG );
			RL_BeginMode3D( $CAMERA );
				RL_DrawCube     ( $CUBE_POSITION , 2.0 , 2.0 , 2.0 , RL_RED    );
				RL_DrawCubeWires( $CUBE_POSITION , 2.0 , 2.0 , 2.0 , RL_MAROON );
				RL_DrawGrid( 40 , 1.0 );
			RL_EndMode3D();
		RL_EndVrStereoMode();
	RL_EndTextureMode();

	RL_BeginDrawing();
		RL_ClearBackground( RL_RAYWHITE );
		RL_BeginShaderMode( $DISTORTION );
			RL_DrawTexturePro( $TARGET->texture , $SRC_RECT , $DST_RECT , RL_Vector2( 0.0 , 0.0 ) , 0.0 , RL_WHITE );
		RL_EndShaderMode();
		RL_DrawFPS( 10 , 10 );
	RL_EndDrawing();
}

RL_UnloadVrStereoConfig( $CONFIG );

RL_UnloadRenderTexture( $TARGET );
RL_UnloadShader( $DISTORTION );

RL_CloseWindow();

//EOF
