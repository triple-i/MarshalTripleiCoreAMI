<?php


namespace Marshal;

class MarshalTripleiCoreAmi
{

    /**
     * @var Ec2Client
     **/
    private $ec2_client;


    /**
     * @param  Ec2Client $ec2_client
     * @return void
     **/
    public function setEc2Client (\Aws\Ec2\Ec2Client $ec2_client)
    {
        $this->ec2_client = $ec2_client;
    }


    /**
     * @return boolean
     **/
    public function execute ()
    {
        $this->_validateParameters();

        $images = $this->_getImages();
        $this->_destroyImages($images);

        return true;
    }


    /**
     * @return void
     **/
    private function _validateParameters ()
    {
        if (is_null($this->ec2_client)) {
            throw new \Exception('Ec2Clientクラスが指定されていません');
        }
    }


    /**
     *  @return array
     **/
    private function _getImages ()
    {
        $results = $this->ec2_client->describeImages([
            'Owners' => ['self'],
            'Filters' => [
                [
                    'Name' => 'tag:Name',
                    'Values' => ['TripleI/Core']
                ]
            ]
        ]);

        return $results->get('Images');
    }


    /**
     * @param  array $images
     * @return void
     **/
    private function _destroyImages ($images)
    {
        if (count($images) <= 3) return false;

        $data = [];
        foreach ($images as $image) {
            $data[$image['ImageId']] = $image['Name'];
        }

        // Nameを降順でソートにする
        arsort($data);

        $i = 1;
        foreach ($data as $image_id => $name) {
            if ($i <= 3) {
                $i++;
                continue;
            }

            $this->ec2_client->deregisterImage([
                'ImageId' => $image_id
            ]);
            $i++;
        }
    }

}

