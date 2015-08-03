<?php
    class Model_Feed extends EntityPHP\Entity
    {
        protected $author;
        protected $object;
        protected $types;

        const 	OBJECT_IS_A_SEND_FILE   =   0,
                OBJECT_IS_A_LIKED_FILE  =   1,
                OBJECT_IS_A_COMMENTARY  =   2;

        protected static $table_name = 'feed';

        public function __construct(Model_Users $author = null, $object = null, $type = null)
        {
            $this->author = $author;
            $this->object = $object;
            $this->type = $type;
        }

        public static function __structure()
        {
            return [
                'author' => 'Model_Users',
                'object' => 'TINYINT(1)',
                'type' => 'TINYINT(1)',
            ];
        }
    }