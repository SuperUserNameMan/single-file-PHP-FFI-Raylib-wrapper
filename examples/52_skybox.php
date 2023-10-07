<?php
//TAB=4

/**
	This one is a little tricky.

	1) Raylib 4.5 does not yet support RL_CUBEMAP_LAYOUT_PANORAMA, and we don't want to use shaders
		- so we use a Mesh Sphere to which we bind our panorama texture, but ...
	2) TexCoords of GenMeshSphere() are rotated 90°
		- so the image of the texture has to be rotated -90°
	3) Vertices of GenMeshSphere() are also rotated 90° (instead of North and South poles, it has East and West poles)
		- so the model has to be rotated 90 when drawn

**/

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [models] example - skybox loading and drawing" );
RL_SetWindowState( RL_FLAG_WINDOW_RESIZABLE );

$CAMERA = RL_Camera
([
	'position'   => RL_Vector3( 1.0 , 1.0 , 1.0  ) ,
	'target'     => RL_Vector3( 4.0 , 1.0 , 4.0  ) ,
	'up'         => RL_Vector3( 0.0 , 1.0 , 0.0  ) ,
	'fovy'       => 45.0 ,
	'projection' => RL_CAMERA_PERSPECTIVE ,
]);

$SPHERE = RL_GenMeshSphere( 1.0 , 36.0 , 20.0 );

$SKYBOX = RL_LoadModelFromMesh( $SPHERE );

$SKYBOX_FILENAME = "" ;

set_skybox_texture( './raylib/examples/resources/skymap.png' );

function set_skybox_texture( string $FILE_PATH ) : void
{
	global $SKYBOX , $BALL ;

	$IMG = RL_LoadImage( $FILE_PATH );
	RL_ImageRotateCCW( $IMG );

	RL_UnloadTexture( $SKYBOX->materials[0]->maps[ RL_MATERIAL_MAP_ALBEDO ]->texture );
	$TEXTURE = RL_LoadTextureFromImage( $IMG ) ;
	RL_SetTextureFilter( $TEXTURE , RL_TEXTURE_FILTER_BILINEAR );
	$SKYBOX->materials[0]->maps[ RL_MATERIAL_MAP_ALBEDO ]->texture = $TEXTURE ;

	RL_UnloadImage( $IMG );
}

//RL_DisableCursor();

RL_SetTargetFPS(60);

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_LEFT ) )
	{
		RL_IsCursorHidden() ? RL_EnableCursor() : RL_DisableCursor();
	}

	RL_UpdateCamera( $CAMERA , RL_CAMERA_FIRST_PERSON );

	if ( RL_IsFileDropped() )
	{
		$DROPPED_FILES = RL_LoadDroppedFiles();

		if ( $DROPPED_FILES->count == 1 )
		{
			$FILE_PATH = FFI::string( $DROPPED_FILES->paths[0] );
			if ( RL_IsFileExtension( $FILE_PATH , '.png;.jpg;.hdr;.bmp;.tga;.jpeg;' ) )
			{
				set_skybox_texture( $FILE_PATH );
			}
			$SKYBOX_FILENAME = $FILE_PATH ;
		}
		RL_UnloadDroppedFiles( $DROPPED_FILES );    // Unload filepaths from memory
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_BeginMode3D( $CAMERA );

			// We are inside the cube, we need to disable backface culling!
			RL_rlDisableBackfaceCulling();
				RL_rlDisableDepthMask();
					RL_rlPushMatrix();
						RL_rlTranslatef( $CAMERA->position->x , $CAMERA->position->y , $CAMERA->position->z );
						RL_rlRotatef( -90.0 , 1.0 , 0.0 , 0.0 );
						RL_DrawModel( $SKYBOX , RL_Vector3( 0 , 0 , 0 ) , 100.0 , RL_WHITE );
					RL_rlPopMatrix();
				RL_rlEnableDepthMask();
			RL_rlEnableBackfaceCulling();

			RL_DrawGrid( 10 , 1.0 );

		RL_EndMode3D();

		RL_DrawText( $SKYBOX_FILENAME , 10 , RL_GetScreenHeight() - 30 , 10 , RL_BLACK );

		RL_DrawFPS( 10 , 10 );

		RL_DrawText( "Mouse click toggle mouse control" , 10 , RL_GetScreenHeight() - 20 , 20 , RL_BLACK );

	RL_EndDrawing();
}

RL_UnloadTexture( $SKYBOX->materials[0]->maps[ RL_MATERIAL_MAP_ALBEDO ]->texture );

RL_UnloadModel( $SKYBOX );

RL_CloseWindow();

//EOF
