<?php
//TAB=4

include('./raylib/raylib.ffi.php');

define( 'G_FORCE' , 400 );
define( 'PLAYER_JUMP_SPD' , 350.0 );
define( 'PLAYER_HOR_SPD' , 200.0 );

class Player
{
	public object $POSITION ; // RL_Vector2
	public float  $SPEED ;
	public bool   $CAN_JUMP ;
};

class EnvItem
{
	public object $RECT ; // RL_Rectangle
	public int    $BLOCKING ;
	public object $COLOR; // RL_Color

	function __construct( object $RECT , int $BLOCKING , object $COLOR )
	{
		$this->RECT     = $RECT ; // by reference
		$this->BLOCKING = $BLOCKING ;
		$this->COLOR    = $COLOR ; // by reference
	}
};


$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - 2d camera" );

$PLAYER = new Player();
$PLAYER->POSITION = RL_Vector2( 400 , 280 );
$PLAYER->SPEED    = 0.0 ;
$PLAYER->CAN_JUMP = false ;

$ENV_ITEMS = [
	new EnvItem( RL_Rectangle(   0 ,   0 , 1000 , 400 ) , 0 , RL_LIGHTGRAY ),
	new EnvItem( RL_Rectangle(   0 , 400 , 1000 , 200 ) , 1 , RL_GRAY ),
	new EnvItem( RL_Rectangle( 300 , 200 ,  400 ,  10 ) , 1 , RL_GRAY ),
	new EnvItem( RL_Rectangle( 250 , 300 ,  100 ,  10 ) , 1 , RL_GRAY ),
	new EnvItem( RL_Rectangle( 650 , 300 ,  100 ,  10 ) , 1 , RL_GRAY ),
];

$CAMERA = RL_Camera2D();
$CAMERA->target   = $PLAYER->POSITION ; // copied
$CAMERA->offset   = RL_Vector2( $SCREEN_W / 2.0 , $SCREEN_H / 2.0 );
$CAMERA->rotation = 0.0 ;
$CAMERA->zoom     = 1.0 ;

$CAMERA_UPDATERS = [
	[ 'UpdateCameraCenter'            , "Follow player center" ],
	[ 'UpdateCameraCenterInsideMap'   , "Follow player center, but clamp to map edges" ],
	[ 'UpdateCameraCenterSmoothFollow', "Follow player center; smoothed" ],
	[ 'UpdateCameraEvenOutOnLanding'  , "Follow player center horizontally; update player center vertically after landing" ],
	[ 'UpdateCameraPlayerBoundsPush'  , "Player push camera on getting too close to screen edge" ],
];

$CAMERA_OPTION = 0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	$DELTA_TIME = RL_GetFrameTime();

	UpdatePlayer( $PLAYER , $ENV_ITEMS , $DELTA_TIME );

	$CAMERA->zoom += RL_GetMouseWheelMove() * 0.05 ;

	if     ( $CAMERA->zoom > 3.0  ) $CAMERA->zoom = 3.0  ;
	elseif ( $CAMERA->zoom < 0.25 ) $CAMERA->zoom = 0.25 ;

	if ( RL_IsKeyPressed( RL_KEY_R) )
	{
		$CAMERA->zoom = 1.0 ;
		$PLAYER->POSITION = RL_Vector2( 400 , 280 );
	}

	if ( RL_IsKeyPressed( RL_KEY_C ) ) $CAMERA_OPTION = ( $CAMERA_OPTION + 1 ) % count( $CAMERA_UPDATERS );

	// Call update camera function by its pointer
	($CAMERA_UPDATERS[ $CAMERA_OPTION ][0])( $CAMERA , $PLAYER , $ENV_ITEMS , $DELTA_TIME , $SCREEN_W , $SCREEN_H );


	RL_BeginDrawing();

		RL_ClearBackground( RL_LIGHTGRAY );

		RL_BeginMode2D( $CAMERA );

			for( $i = 0 ; $i < count( $ENV_ITEMS ) ; $i++ )
			{
				RL_DrawRectangleRec( $ENV_ITEMS[ $i ]->RECT , $ENV_ITEMS[ $i ]->COLOR );
			}

			$PLAYER_RECT = RL_Rectangle( $PLAYER->POSITION->x - 20 , $PLAYER->POSITION->y - 40 , 40, 40 );
			RL_DrawRectangleRec( $PLAYER_RECT , RL_RED );

		RL_EndMode2D();

		RL_DrawText( "Controls:" , 20 , 20 , 10 , RL_BLACK );
		RL_DrawText( "- Right/Left to move" , 40 , 40 , 10 , RL_DARKGRAY );
		RL_DrawText( "- Space to jump" , 40 , 60 , 10 , RL_DARKGRAY );
		RL_DrawText( "- Mouse Wheel to Zoom in-out, R to reset zoom" , 40 , 80 , 10 , RL_DARKGRAY );
		RL_DrawText( "- C to change camera mode" , 40 , 100 , 10 , RL_DARKGRAY );
		RL_DrawText( "Current camera mode:" , 20 , 120 , 10 , RL_BLACK );
		RL_DrawText( $CAMERA_UPDATERS[ $CAMERA_OPTION ][1] , 40 , 140 , 10 , RL_DARKGRAY );

	RL_EndDrawing();
}


RL_CloseWindow();



function UpdatePlayer( Player $PLAYER , array $ENV_ITEMS , float $DELTA_TIME ) : void
{
	if ( RL_IsKeyDown( RL_KEY_LEFT  ) ) $PLAYER->POSITION->x -= PLAYER_HOR_SPD * $DELTA_TIME ;
	if ( RL_IsKeyDown( RL_KEY_RIGHT ) ) $PLAYER->POSITION->x += PLAYER_HOR_SPD * $DELTA_TIME ;
	if ( RL_IsKeyDown( RL_KEY_SPACE ) && $PLAYER->CAN_JUMP )
	{
		$PLAYER->SPEED    = -PLAYER_JUMP_SPD;
		$PLAYER->CAN_JUMP = false ;
	}

	$HIT_OBSTACLE = false ;

	for( $i = 0 ; $i < count( $ENV_ITEMS ) ; $i++ )
	{
		$ITEM = $ENV_ITEMS[ $i ] ;

		if(
			$ITEM->BLOCKING
			&&
			$ITEM->RECT->x <= $PLAYER->POSITION->x
			&&
			$ITEM->RECT->x + $ITEM->RECT->width >= $PLAYER->POSITION->x
			&&
			$ITEM->RECT->y >= $PLAYER->POSITION->y
			&&
			$ITEM->RECT->y <= $PLAYER->POSITION->y + $PLAYER->SPEED * $DELTA_TIME
		){
			$HIT_OBSTACLE = true ;
			$PLAYER->SPEED = 0.0 ;
			$PLAYER->POSITION->y = $ITEM->RECT->y;
		}
	}

	if ( ! $HIT_OBSTACLE )
	{
		$PLAYER->POSITION->y += $PLAYER->SPEED * $DELTA_TIME ;
		$PLAYER->SPEED += G_FORCE * $DELTA_TIME ;
		$PLAYER->CAN_JUMP = false ;
	}
	else
	{
		$PLAYER->CAN_JUMP = true ;
	}
}

function UpdateCameraCenter( object $CAMERA , Player $PLAYER , array $ENV_ITEMS , float $DELTA_TIME , int $WIDTH , int $HEIGHT ) : void
{
	$CAMERA->offset = RL_Vector2( $WIDTH / 2.0 , $HEIGHT / 2.0 );
	$CAMERA->target = $PLAYER->POSITION ; // by copy because $CAMERA is pure CData
}

function UpdateCameraCenterInsideMap( object $CAMERA , Player $PLAYER , array $ENV_ITEMS , float $DELTA_TIME , int $WIDTH , int $HEIGHT ) : void
{
	$CAMERA->target = $PLAYER->POSITION ;  // by copy because $CAMERA is pure CData
	$CAMERA->offset = RL_Vector2( $WIDTH / 2.0 , $HEIGHT /2.0 );

    $MIN_X =  10000.0 ;	$MIN_Y =  10000.0 ;
	$MAX_X = -10000.0 ;	$MAX_Y = -10000.0 ;

	for( $i = 0 ; $i < count( $ENV_ITEMS ) ; $i++ )
	{
		$ITEM = $ENV_ITEMS[ $i ];

		$MIN_X = min( $ITEM->RECT->x                       , $MIN_X );
		$MAX_X = max( $ITEM->RECT->x + $ITEM->RECT->width  , $MAX_X );
		$MIN_Y = min( $ITEM->RECT->y                       , $MIN_Y );
		$MAX_Y = max( $ITEM->RECT->y + $ITEM->RECT->height , $MAX_Y );
	}

	$MAX = RL_GetWorldToScreen2D( RL_Vector2( $MAX_X , $MAX_Y ) , $CAMERA );
	$MIN = RL_GetWorldToScreen2D( RL_Vector2( $MIN_X , $MIN_Y ) , $CAMERA );

	if ( $MAX->x < $WIDTH  ) $CAMERA->offset->x = $WIDTH  - ( $MAX->x - $WIDTH /2.0 );
	if ( $MAX->y < $HEIGHT ) $CAMERA->offset->y = $HEIGHT - ( $MAX->y - $HEIGHT/2.0 );
	if ( $MIN->x > 0       ) $CAMERA->offset->x = $WIDTH /2.0 - $MIN->x ;
	if ( $MIN->y > 0       ) $CAMERA->offset->y = $HEIGHT/2.0 - $MIN->y ;
}


function UpdateCameraCenterSmoothFollow( object $CAMERA , Player $PLAYER , array $ENV_ITEMS , float $DELTA_TIME , int $WIDTH , int $HEIGHT ) : void
{
	static $MIN_SPEED         = 30.0 ;
	static $MIN_EFFECT_LENGTH = 10.0 ;
	static $FRACTION_SPEED    =  0.8 ;

	$CAMERA->offset = RL_Vector2( $WIDTH/2.0 , $HEIGHT/2.0 );
	$DIFF = RL_Vector2Subtract( $PLAYER->POSITION , $CAMERA->target );
	$LENGTH = RL_Vector2Length( $DIFF );

	if ( $LENGTH > $MIN_EFFECT_LENGTH )
	{
		$SPEED = max( $FRACTION_SPEED * $LENGTH , $MIN_SPEED );
		$CAMERA->target = RL_Vector2Add( $CAMERA->target , RL_Vector2Scale( $DIFF , $SPEED*$DELTA_TIME/$LENGTH ) );
    }
}

function UpdateCameraEvenOutOnLanding( object $CAMERA , Player $PLAYER , array $ENV_ITEMS , float $DELTA_TIME , int $WIDTH , int $HEIGHT ) : void
{
	static $EVEN_OUT_SPEED  = 700.0 ;
	static $EVENING_OUT     = false ;
	static $EVEN_OUT_TARGET = 0.0 ;

	$CAMERA->offset    = RL_Vector2( $WIDTH/2.0 , $HEIGHT/2.0 );
	$CAMERA->target->x = $PLAYER->POSITION->x ;

	if ( $EVENING_OUT )
	{
		if ( $EVEN_OUT_TARGET > $CAMERA->target->y )
		{
			$CAMERA->target->y += $EVEN_OUT_SPEED * $DELTA_TIME ;

			if ( $CAMERA->target->y > $EVEN_OUT_TARGET )
			{
				$CAMERA->target->y = $EVEN_OUT_TARGET ;
				$EVENING_OUT = false ;
			}
		}
		else
		{
			$CAMERA->target->y -= $EVEN_OUT_SPEED * $DELTA_TIME ;

			if ( $CAMERA->target->y < $EVEN_OUT_TARGET )
			{
				$CAMERA->target->y = $EVEN_OUT_TARGET ;
				$EVENING_OUT = false ;
			}
		}
	}
	else
	{
		if ( $PLAYER->CAN_JUMP && ( $PLAYER->SPEED == 0 ) && ( $PLAYER->POSITION->y != $CAMERA->target->y ) )
		{
			$EVENING_OUT = true ;
			$EVEN_OUT_TARGET = $PLAYER->POSITION->y ;
		}
	}
}

function UpdateCameraPlayerBoundsPush( object $CAMERA , Player $PLAYER , array $ENV_ITEMS , float $DELTA_TIME , int $WIDTH , int $HEIGHT ) : void
{
    static $BBOX = null ;

	$BBOX ??= RL_Vector2( 0.2 , 0.2 );

    $BBOX_WORLD_MIN = RL_GetScreenToWorld2D( RL_Vector2( ( 1.0 - $BBOX->x )*0.5*$WIDTH , ( 1.0 - $BBOX->y )*0.5*$HEIGHT ) , $CAMERA );
	$BBOX_WORLD_MAX = RL_GetScreenToWorld2D( RL_Vector2( ( 1.0 + $BBOX->x )*0.5*$WIDTH , ( 1.0 + $BBOX->y )*0.5*$HEIGHT ) , $CAMERA );
	$CAMERA->offset = RL_Vector2( ( 1.0 - $BBOX->x )*0.5*$WIDTH , ( 1.0 - $BBOX->y )*0.5*$HEIGHT );

	if ( $PLAYER->POSITION->x < $BBOX_WORLD_MIN->x ) $CAMERA->target->x = $PLAYER->POSITION->x ;
	if ( $PLAYER->POSITION->y < $BBOX_WORLD_MIN->y ) $CAMERA->target->y = $PLAYER->POSITION->y ;
	if ( $PLAYER->POSITION->x > $BBOX_WORLD_MAX->x ) $CAMERA->target->x = $BBOX_WORLD_MIN->x + ( $PLAYER->POSITION->x - $BBOX_WORLD_MAX->x ) ;
	if ( $PLAYER->POSITION->y > $BBOX_WORLD_MAX->y ) $CAMERA->target->y = $BBOX_WORLD_MIN->y + ( $PLAYER->POSITION->y - $BBOX_WORLD_MAX->y ) ;
}

//EOF
