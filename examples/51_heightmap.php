<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [models] example - heightmap loading and drawing" );
RL_SetWindowState( RL_FLAG_WINDOW_RESIZABLE );

$CAMERA = RL_Camera([
	'position'   => RL_Vector3( 18.0 , 21.0 , 18.0  ) ,
	'target'     => RL_Vector3(  0.0 ,  0.0 ,  0.0  ) ,
	'up'         => RL_Vector3(  0.0 ,  1.0 ,  0.0  ) ,
	'fovy'       => 45.0 ,
	'projection' => RL_CAMERA_PERSPECTIVE ,
]);

$HEIGHTMAP = RL_LoadImage('./raylib/examples/resources/heightmap.png');
$COLORMAP  = RL_LoadImage('./raylib/examples/resources/colormap.png');

RL_ImageMipmaps( $COLORMAP );

if ( RL_SUPPORT_MESH_GENERATION )
{
	$MESH_RMESH    = RL_GenMeshHeightmap( $HEIGHTMAP , RL_Vector3( 16 , 4 , 16 ) );
}

$MESH_CUSTOM    = CustomGenMeshHeightmap( $HEIGHTMAP , RL_Vector3( 16 , 4 , 16 ) );

$TEXTURE = RL_LoadTextureFromImage( $COLORMAP );
RL_SetTextureFilter( $TEXTURE , RL_TEXTURE_FILTER_TRILINEAR );

if ( RL_SUPPORT_MESH_GENERATION )
{
	$MODEL_RMESH = RL_LoadModelFromMesh( $MESH_RMESH );
	$MODEL_RMESH->materials[0]->maps[ RL_MATERIAL_MAP_DIFFUSE ]->texture = $TEXTURE ;
}

$MODEL_CUSTOM = RL_LoadModelFromMesh( $MESH_CUSTOM );
$MODEL_CUSTOM->materials[0]->maps[ RL_MATERIAL_MAP_DIFFUSE ]->texture = $TEXTURE ;

$MAP_POSITION = RL_Vector3( -8.0 , 0.0 , -8.0 );

RL_UnloadImage( $COLORMAP );
RL_UnloadImage( $HEIGHTMAP );


RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	RL_UpdateCamera( $CAMERA , RL_CAMERA_ORBITAL );

	RL_BeginDrawing();

		RL_ClearBackground( RL_SKYBLUE );

		RL_BeginMode3D( $CAMERA );

			if ( RL_SUPPORT_MESH_GENERATION && RL_IsKeyDown( RL_KEY_SPACE ) )
			{
				RL_DrawModel( $MODEL_RMESH , $MAP_POSITION , 1.0 , RL_WHITE );
				$GENERATOR = "RMESH";
			}
			else
			{
				RL_DrawModel( $MODEL_CUSTOM , $MAP_POSITION , 1.0 , RL_WHITE );
				$GENERATOR = "CUSTOM";
			}

			RL_DrawGrid( 20 , 1.0 );

		RL_EndMode3D();

		RL_DrawFPS( 10 , 10 );

		if ( RL_SUPPORT_MESH_GENERATION )
		{
			RL_DrawText( "Press SPACE to toggle mesh generator ..." , 10 , RL_GetScreenHeight() - 30 , 20 , RL_RED );

			RL_DrawText( "Current generator : $GENERATOR" , 10 , RL_GetScreenHeight() - 50 , 20 , RL_RED );
		}

	RL_EndDrawing();
}

RL_UnloadTexture( $TEXTURE );
RL_UnloadModel( $MODEL_CUSTOM );
RL_UnloadModel( $MODEL_RMESH );

RL_CloseWindow();

// ----------------

function HeightmapNormal( float $Center , float $North , float $East , float $South , float $West ) : object // Vector3
{
	$SUM  = RL_Vector3();

	$PLANE = RL_Vector3CrossProduct( RL_Vector3( 0 , $North - $Center , 0 ) , RL_Vector3( 0 , $East - $Center , 0 ) );
	$SUM = RL_Vector3Add( $SUM , $PLANE );

	$PLANE = RL_Vector3CrossProduct( RL_Vector3( 0 , $East - $Center , 0 ) , RL_Vector3( 0 , $South - $Center , 0 ) );
	$SUM = RL_Vector3Add( $SUM , $PLANE );

	$PLANE = RL_Vector3CrossProduct( RL_Vector3( 0 , $South - $Center , 0 ) , RL_Vector3( 0 , $West - $Center , 0 ) );
	$SUM = RL_Vector3Add( $SUM , $PLANE );

	$PLANE = RL_Vector3CrossProduct( RL_Vector3( 0 , $West - $Center , 0 ) , RL_Vector3( 0 , $North - $Center , 0 ) );
	$SUM = RL_Vector3Add( $SUM , $PLANE );

	return RL_Vector3Normalize( $SUM );
}

function CustomGenMeshHeightmap( object $heightmap_image , object $size_vec3 ) : object // Mesh
{
#define GRAY_VALUE(c) ((float)(c.r + c.g + c.b)/3.0f)

	$MESH = RL_Mesh();

	$MAP_XLEN = $heightmap_image->width ;
	$MAP_ZLEN = $heightmap_image->height ;

	$PIXELS = RL_LoadImageColors( $heightmap_image );


	// A-----B		A,B,C,D are pixels
	// |    /|
	// |  /  |
	// |/    |
	// D-----C

	$MESH->triangleCount = ( $MAP_XLEN )*( $MAP_ZLEN  )*2 ;

	$MESH->vertexCount   = $MAP_XLEN * $MAP_ZLEN ;

	$VERTICES  = RL_Vector3_alloc( $MESH->vertexCount ) ;
	$NORMALS   = RL_Vector3_alloc( $MESH->vertexCount ) ;
	$TEXCOORDS = RL_Vector2_alloc( $MESH->vertexCount ) ;
	$COLORS    = RL_Color_alloc  ( $MESH->vertexCount ) ;

	$MESH->vertices  = FFI::cast( 'float*' , FFI::addr( $VERTICES[0]  ) );
	$MESH->normals   = FFI::cast( 'float*' , FFI::addr( $NORMALS[0]   ) );
	$MESH->texcoords = FFI::cast( 'float*' , FFI::addr( $TEXCOORDS[0] ) );

	$MESH->colors    = FFI::cast( 'uint8_t*' , FFI::addr( $COLORS[0]    ) );

	$INDICES = FFI::new('uint16_t['.($MESH->triangleCount*3).']',false,true); // unmanaged array will be deleted by raylib

	$MESH->indices = FFI::cast( 'uint16_t*' , FFI::addr( $INDICES[0] ) );

	$V_COUNTER = 0 ;
	$T_COUNTER = 0 ;
	$N_COUNTER = 0 ;

	$SCALE_FACTOR = RL_Vector3Divide( $size_vec3 , RL_Vector3( $MAP_XLEN - 1 , 255.0 , $MAP_ZLEN - 1 ) );

	for( $z = 0 ; $z < $MAP_ZLEN ; $z++ )
	{
		$SHADOW_COUNTER = 0 ;

		for( $x = 0 ; $x < $MAP_XLEN ; $x++ )
		{
			$a = $x + $z * $MAP_XLEN ;

			$h = $PIXELS[ $a ]->r ;

			$VERTICES [ $a ] = RL_Vector3Multiply( RL_Vector3( $x , $h , $z ) , $SCALE_FACTOR );
			$TEXCOORDS[ $a ] = RL_Vector2( (float)$x / (float)$MAP_XLEN , (float)$z / (float)$MAP_ZLEN );

			$NORTH = $PIXELS[ $x + max( 0 , $z - 1 ) * $MAP_XLEN ]->r;
			$SOUTH = $PIXELS[ $x + min( $MAP_ZLEN-1 , $z + 1 ) * $MAP_XLEN ]->r;

			$WEST  = $PIXELS[ max( 0 , $x - 1 ) + $z * $MAP_XLEN ]->r;
			$EAST  = $PIXELS[ min( $MAP_XLEN -1 , $x + 1 ) + $z * $MAP_XLEN ]->r;

			$NORMALS  [ $a ] = HeightmapNormal( $h , $NORTH , $EAST , $SOUTH , $WEST );

			// pseudo shadows jsut to test the colors :

			$SHADOW_COUNTER = max( $SHADOW_COUNTER , $WEST - $h ) ;

			if ( $SHADOW_COUNTER )
			{
				$COLORS[ $a ] = RL_Color( 230,230,230,255 ) ;
				$SHADOW_COUNTER--;
			}
			else
			{
				$COLORS[ $a ] = RL_WHITE ;
			}
		}
	}

	for( $z = 0 ; $z < $MAP_ZLEN-1 ; $z++ )
	{
		for( $x = 0 ; $x < $MAP_XLEN-1 ; $x++ )
		{
			$a = $x + $z * $MAP_XLEN ;

			// A+0 ---- A+1
			//  |      / |
			//  |    /   |
			//  |  /     |
			// A+0 ---- A+1    + MAP_XLEN

			$MESH->indices[ $a * 6 + 0 ] = $a + 0 ;
			$MESH->indices[ $a * 6 + 1 ] = $a + 0 + $MAP_XLEN ;
			$MESH->indices[ $a * 6 + 2 ] = $a + 1 ;

			$MESH->indices[ $a * 6 + 3 ] = $a + 1 ;
			$MESH->indices[ $a * 6 + 4 ] = $a + 0 + $MAP_XLEN;
			$MESH->indices[ $a * 6 + 5 ] = $a + 1 + $MAP_XLEN ;
		}
	}

	RL_UnloadImageColors( $PIXELS );

	// Upload vertex data to GPU (static mesh)
	RL_UploadMesh( $MESH , false );

	return $MESH ;
}

//EOF
