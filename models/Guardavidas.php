<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Guardavidas".
 *
 * @property int $idGuardavidas
 * @property string $Nombre
 * @property int $idRol
 * @property string $idTelegram
 * @property string $Mail
 *
 * @property Asistencia[] $asistencias
 * @property Rol $idRol0
 * @property GuardavidasPuesto[] $guardavidasPuestos
 */
class Guardavidas extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    /**
     * {@inheritdoc}
     */
    private $username;
    
    public function getUsername(){
        return $this->Nombre;
    }
    public static function tableName() {
        return 'Guardavidas';
    }

    public static function findByUsername($username) {
        return self::findOne(['Nombre' => $username]);
    }

    public function validatePassword($password) {
        return $this->idTelegram === $password;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['Nombre', 'idRol', 'idTelegram', 'Mail'], 'required'],
                [['idRol'], 'integer'],
                [['Nombre', 'idTelegram', 'Mail'], 'string', 'max' => 100],
                [['idRol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['idRol' => 'idRol']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idGuardavidas' => 'Id Guardavidas',
            'Nombre' => 'Nombre',
            'idRol' => 'Id Rol',
            'idTelegram' => 'Id Telegram',
            'Mail' => 'Mail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsistencias() {
        return $this->hasMany(Asistencia::className(), ['idGuardavidas' => 'idGuardavidas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRol0() {
        return $this->hasOne(Rol::className(), ['idRol' => 'idRol']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuardavidasPuestos() {
        return $this->hasMany(GuardavidasPuesto::className(), ['idGuardavidas' => 'idGuardavidas']);
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId() {
        return $this->idGuardavidas;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey() {
        return $this->idGuardavidas;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

}
