<?php


use Marshal\MarshalTripleiCoreAmi;
use Marshal\Mock\MockTestCase;

class MarshalTripleiCoreAmiTest extends MockTestCase
{

    /**
     * @var MarshalTripleiCoreAmi
     **/
    private $marshal;


    /**
     * @var Ec2Client
     **/
    private $ec2_client;


    /**
     * @return void
     **/
    public function setUp ()
    {
        $this->marshal = new MarshalTripleiCoreAmi();
        $this->ec2_client = $this->getEc2Mock();
    }


    /**
     * @test
     * @expectedException          \Exception
     * @expectedExceptionMessage   Ec2Clientクラスが指定されていません
     * @group marshal-not-set-ec2client
     * @group marshal
     **/
    public function Ec2Clientクラスが指定されていない場合 ()
    {
        $this->marshal->execute();
    }


    /**
     * @test
     * @group marshal-execute
     * @group marshal
     **/
    public function 正常な処理 ()
    {
        // AMIが三つしかない場合
        $results = [
            ['ImageId' => 'img-001', 'Name' => 'TripleI/Core 001'],
            ['ImageId' => 'img-002', 'Name' => 'TripleI/Core 112'],
            ['ImageId' => 'img-003', 'Name' => 'TripleI/Core 2014333']
        ];

        $model = $this->getMock('Guzzle\Service\Resource\Model', ['get']);
        $model->expects($this->any())
            ->method('get')->will($this->returnValue($results));

        $this->ec2_client->expects($this->any())
            ->method('describeImages')
            ->will($this->returnValue($model));

        $this->marshal->setEc2Client($this->ec2_client);
        $result = $this->marshal->execute();
        $this->assertTrue($result);


        // AMIが三つ以上ある場合
        $results[] = ['ImageId' => 'img-004', 'Name' => 'TripleI/Core 2012102010240'];

        $model = $this->getMock('Guzzle\Service\Resource\Model', ['get']);
        $model->expects($this->any())
            ->method('get')->will($this->returnValue($results));

        $this->ec2_client = $this->getEc2Mock();
        $this->ec2_client->expects($this->any())
            ->method('describeImages')
            ->will($this->returnValue($model));

        $this->marshal->setEc2Client($this->ec2_client);
        $result = $this->marshal->execute();
        $this->assertTrue($result);
    }

}

