<?php
    class Model_Feed extends EntityPHP\Entity
    {
        protected $author;
        protected $object;
        protected $type;

        const 	OBJECT_IS_A_SENT_FILE   =   0,
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
        
        public static function getGalleryFeed($userId, $fileId, $type = null)
        {
            if($type == self::OBJECT_IS_A_COMMENTARY)
            {
                $request = self::createRequest();
                return $request->where('author.id=? AND object=? AND type=?', [$userId, $fileId, $type])
                               ->getOnly(1)
							   ->exec();
            }
            elseif($type == self::OBJECT_IS_A_LIKED_FILE)
            {
                $request = self::createRequest();
                return $request->where('author.id=? AND object=? AND type=?', [$userId, $fileId, $type])
                       ->exec();
            }
        }
    }