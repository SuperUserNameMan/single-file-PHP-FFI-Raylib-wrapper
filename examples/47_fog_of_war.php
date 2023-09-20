<?php
//TAB=4

include('./raylib/raylib.ffi.php');

define( 'MAP_TILE_SIZE'       , 32 );
define( 'PLAYER_SIZE'         , 16 );
define( 'PLAYER_VISION_RANGE' ,  2 );

class Map
{
	public int $W ;
	public int $H ;
	public array $TID ;
	public array $FOG ;

	public object $TILESET_TEXTURE ;
	public string $TILESET_PATH ;

	public int $TILESET_W ;
	public int $TILESET_H ;
	public int $TILESET_SIZE ;

	public object $FOG_RENDER_TEXTURE ;

	public array $TILES ;


	function __construct( int $w , int $h , string $tileset_path )
	{
		$this->W = $w ;
		$this->H = $h ;

		$this->TID = [];
		$this->FOG = [];

		$this->TILESET_TEXTURE = RL_LoadTexture( $tileset_path );
		$this->TILESET_PATH = $tileset_path ;

		$this->FOG_RENDER_TEXTURE = RL_LoadRenderTexture( $w , $h );
		RL_SetTextureFilter( $this->FOG_RENDER_TEXTURE->texture , RL_TEXTURE_FILTER_BILINEAR );
		RL_SetTextureWrap  ( $this->FOG_RENDER_TEXTURE->texture , RL_TEXTURE_WRAP_CLAMP      );

		$this->TILESET_W = $this->TILESET_TEXTURE->width  / MAP_TILE_SIZE ;
		$this->TILESET_H = $this->TILESET_TEXTURE->height / MAP_TILE_SIZE ;

		$this->TILESET_SIZE = $this->TILESET_W * $this->TILESET_H ;

		for( $TID = 0 ; $TID < $this->TILESET_SIZE ; $TID++ )
		{
			$TX = MAP_TILE_SIZE * (int)( $TID % $this->W ) ;
			$TY = MAP_TILE_SIZE * (int)( ( $TID - $TX ) / $this->W );

			$REC = RL_Rectangle( $TX , $TY , MAP_TILE_SIZE , MAP_TILE_SIZE );

			$this->TILES[ $TID ] = $REC ;
		}

		for( $y = 0 ; $y < $this->H ; $y++ )
		{
			for( $x = 0 ; $x < $this->W ; $x++ )
			{
				$a = $x + $y * $this->W ;
				$this->TID[ $a ] = ( rand() % 100 < 90 ) ? 0 : rand() % $this->TILESET_SIZE ;
				$this->FOG[ $a ] = 0 ;
			}
		}
	}

	function __destruct()
	{
		RL_UnloadTexture( $this->TILESET_TEXTURE );
		RL_UnloadRenderTexture( $this->FOG_RENDER_TEXTURE );
	}

	function update_fog( int $player_x , int $player_y ) : void
	{
		// Previously visited tiles are set to partial fog
		foreach( $this->FOG as &$FOG ) { if ( $FOG == 1 ) $FOG = 2 ; }

		// Tiles in player's vision range are clear of fog
		$LEFT  = max( $player_x - PLAYER_VISION_RANGE , 0 );
		$RIGHT = min( $player_x + PLAYER_VISION_RANGE , $this->W );

		$FIRST = max( $player_y - PLAYER_VISION_RANGE , 0 );
		$LAST  = min( $player_y + PLAYER_VISION_RANGE , $this->H );

		for( $y = $FIRST ; $y < $LAST ; $y++ )
		{
			for( $x = $LEFT ; $x < $RIGHT ; $x++ )
			{
				$a = $x + $y * $this->W ;
				$this->FOG[ $a ] = 1 ;
			}
		}

		// update fog's texture ...
		RL_BeginTextureMode( $this->FOG_RENDER_TEXTURE );

			RL_ClearBackground( RL_BLANK );

			for( $y = 0 ; $y < $this->H ; $y++ )
			{
				for( $x = 0 ; $x < $this->W ; $x++ )
				{
					$a = $x + $y * $this->W ;
					$v = 0.05 * sin( RL_GetTime() ) * sin( $a * 0.2 + RL_GetTime() ) ; // fog animation

					switch( $this->FOG[ $a ] )
					{
						case 0 : RL_DrawRectangle( $x , $y , 1 , 1 , RL_Fade( RL_WHITE , 0.9 + $v ) ); break ;
						case 1 : RL_DrawRectangle( $x , $y , 1 , 1 , RL_Fade( RL_WHITE , 0.5 + $v ) ); break ;
						case 2 : RL_DrawRectangle( $x , $y , 1 , 1 , RL_Fade( RL_WHITE , 0.8 + $v ) ); break ;
					}
				}
			}

		RL_EndTextureMode();
	}

	function draw() : void
	{
		for( $y = 0 ; $y < $this->H ; $y++ )
		{
			for( $x = 0 ; $x < $this->W ; $x++ )
			{
				$a = $x + $y * $this->W ;

				RL_DrawTextureRec
				(
					$this->TILESET_TEXTURE ,
					$this->TILES[ $this->TID[ $a ] ] ,
					RL_Vector2( $x * MAP_TILE_SIZE , $y * MAP_TILE_SIZE ),
					RL_WHITE,
				);

			}
		}
	}

	function draw_fog() : void
	{
		RL_DrawTexturePro
		(
			$this->FOG_RENDER_TEXTURE->texture ,
			RL_Rectangle
			(
				0 ,
				0 ,
				(float) $this->FOG_RENDER_TEXTURE->texture->width ,
				(float)-$this->FOG_RENDER_TEXTURE->texture->height
			) ,
			RL_Rectangle
			(
				0 ,
				0 ,
				(float) $this->W * MAP_TILE_SIZE ,
				(float) $this->H * MAP_TILE_SIZE ,
			),
			RL_Vector2( 0 , 0 ) ,
			0.0 ,
			RL_WHITE
		);
	}
}

function keep_inside( int|float $VAL , int|float $MIN , int|float $MAX ) : int|float { return min( $MAX , max( $MIN , $VAL ) ); }

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - fog of war" );

$MAP = new Map( 25 , 15 , './raylib/examples/resources/tileset_grass.png' );

$PLAYER_POS = RL_Vector2( 180 , 130 ); // as screen coordinates in pixels
$PLAYER_TILE_X = 0 ;
$PLAYER_TILE_Y = 0 ;



RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsKeyDown( RL_KEY_RIGHT ) ) $PLAYER_POS->x += 5 ;
	if ( RL_IsKeyDown( RL_KEY_LEFT  ) ) $PLAYER_POS->x -= 5 ;
	if ( RL_IsKeyDown( RL_KEY_DOWN  ) ) $PLAYER_POS->y += 5 ;
	if ( RL_IsKeyDown( RL_KEY_UP    ) ) $PLAYER_POS->y -= 5 ;

	$PLAYER_POS->x = keep_inside( $PLAYER_POS->x , 0 , $MAP->W * MAP_TILE_SIZE - PLAYER_SIZE );
	$PLAYER_POS->y = keep_inside( $PLAYER_POS->y , 0 , $MAP->H * MAP_TILE_SIZE - PLAYER_SIZE );

	// Get current tile position from player pixel position
	$PLAYER_TILE_X = (int)( ( $PLAYER_POS->x + MAP_TILE_SIZE/2 ) / MAP_TILE_SIZE );
	$PLAYER_TILE_Y = (int)( ( $PLAYER_POS->y + MAP_TILE_SIZE/2 ) / MAP_TILE_SIZE );

	$MAP->update_fog( $PLAYER_TILE_X , $PLAYER_TILE_Y );

	RL_BeginDrawing();

		RL_ClearBackground( RL_SKYBLUE );

		$MAP->draw();

		// Draw player
		RL_DrawRectangleV( $PLAYER_POS , RL_Vector2( PLAYER_SIZE , PLAYER_SIZE ) , RL_RED );

		$MAP->draw_fog();

		RL_DrawText( "Current tile: [$PLAYER_TILE_X,$PLAYER_TILE_Y]" , 10 , 10 , 20 , RL_DARKBLUE );
		RL_DrawText( "ARROW KEYS to move" , 10 , $SCREEN_H-25 , 20 , RL_DARKBROWN );

	RL_EndDrawing();
}

unset( $MAP ); // <=== we must trigger the destructor before closing the window

RL_CloseWindow();

//EOF
