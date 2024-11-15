{use class="Yii" }
{use class='yii\helpers\Html'}
{use class='app\models\Book'}
<h1>Indice del Sitio.</h1>

{if Yii::$app->user->isGuest}
hola invitado {Html::a('login',['site/login'])}
{else}
hola {Yii::$app->user->identity->username}
{/if}

<p>{$book_count} Libros en el Sistema</p>