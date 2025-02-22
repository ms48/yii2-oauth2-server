<?php

namespace rhertogh\Yii2Oauth2Server\components\encryption;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\BadFormatException;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Defuse\Crypto\Key;
use rhertogh\Yii2Oauth2Server\interfaces\components\encryption\Oauth2EncryptorInterface;
use rhertogh\Yii2Oauth2Server\interfaces\components\factories\encryption\Oauth2EncryptionKeyFactoryInterface;
use Yii;
use yii\base\Component;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

class Oauth2Encryptor extends Component implements Oauth2EncryptorInterface
{
    /**
     * Separator between different parts in the data. E.g. the keyName and secret.
     * @var string
     */
    public $dataSeparator = '::';

    /**
     * @var Key[]|null
     */
    protected $_keys = null;

    /**
     * @var string|null
     */
    protected $_defaultKeyName = null;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function setKeys($keys)
    {
        if ($keys && is_string($keys)) {
            $keys = Json::decode($keys);
        }

        /** @var Oauth2EncryptionKeyFactoryInterface $keyFactory */
        $keyFactory = Yii::createObject(Oauth2EncryptionKeyFactoryInterface::class);
        $this->_keys = [];
        foreach ($keys as $keyName => $key) {
            try {
                $this->_keys[$keyName] = $keyFactory->createFromAsciiSafeString($key);
            } catch (BadFormatException $e) {
                throw new InvalidConfigException(
                    'Encryption key "' . $keyName . '" is malformed: ' . $e->getMessage(),
                    0,
                    $e
                );
            } catch (EnvironmentIsBrokenException $e) {
                throw new InvalidConfigException(
                    'Could not instantiate key "' . $keyName . '": ' . $e->getMessage(),
                    0,
                    $e
                );
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getDefaultKeyName()
    {
        if (empty($this->_defaultKeyName)) {
            throw new \BadMethodCallException(
                'Unable to get the defaultKeyName since it is not set.'
            );
        }

        return $this->_defaultKeyName;
    }

    /**
     * @inheritDoc
     */
    public function setDefaultKeyName($name)
    {
        $this->_defaultKeyName = $name;
    }

    /**
     * @inheritDoc
     */
    public function hasKey($name)
    {
        return array_key_exists($name, $this->_keys);
    }


    /**
     * @inheritDoc
     * @throws InvalidConfigException
     * @throws EnvironmentIsBrokenException
     */
    public function encryp($data, $keyName = null)
    {
        if (empty($keyName)) {
            $keyName = $this->getDefaultKeyName();
        }

        if (empty($this->_keys[$keyName])) {
            throw new \BadMethodCallException('Unable to encrypt, no key with name "' . $keyName . '" has been set.');
        }

        if (empty($this->dataSeparator)) {
            throw new InvalidConfigException('Unable to encrypt, dataSeparator is empty.');
        }

        if (strpos($keyName, $this->dataSeparator) !== false) {
            throw new \BadMethodCallException(
                'Unable to encrypt, key name "' . $keyName . '" contains dataSeparator "' . $this->dataSeparator . '".'
            );
        }

        return $keyName
            . $this->dataSeparator
            . base64_encode(Crypto::encrypt($data, $this->_keys[$keyName], true));
    }

    /**
     * @inheritDoc
     */
    public function parseData($data)
    {
        $parts = explode($this->dataSeparator, $data);
        if (count($parts) !== 2) {
            throw new InvalidArgumentException(
                'Could not parse encrypted data: invalid number of parts, expected 2 got ' . count($parts)
            );
        }
        return array_combine(['keyName', 'ciphertext'], $parts);
    }

    /**
     * @inheritDoc
     * @throws EnvironmentIsBrokenException
     * @throws WrongKeyOrModifiedCiphertextException
     */
    public function decrypt($data)
    {
        try {
            ['keyName' => $keyName, 'ciphertext' => $ciphertext] = $this->parseData($data);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException(
                'Unable to decrypt, $data must be in format "keyName' . $this->dataSeparator . 'ciphertext".'
            );
        }

        if (empty($this->_keys[$keyName])) {
            throw new \BadMethodCallException('Unable to decrypt, no key with name "' . $keyName . '" has been set.');
        }

        return Crypto::decrypt(base64_decode($ciphertext), $this->_keys[$keyName], true);
    }

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     * @throws EnvironmentIsBrokenException
     * @throws WrongKeyOrModifiedCiphertextException
     */
    public function rotateKey($data, $newKeyName = null)
    {
        if (empty($newKeyName)) {
            $newKeyName = $this->getDefaultKeyName();
        }

        [$keyName] = explode($this->dataSeparator, $data, 2);

        if ($keyName === $newKeyName) {
            return $data; // Key hasn't changed.
        }

        return $this->encryp($this->decrypt($data), $newKeyName);
    }
}
