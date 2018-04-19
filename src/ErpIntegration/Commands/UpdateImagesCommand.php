<?php

namespace App\ErpIntegration\Commands;

use App\Entity\Product;
use App\ErpIntegration\IntegrationEventNotify;
use LHGroup\From1cToWeb\Notify\NotifyInterface;
use LHGroup\From1cToWeb\Publisher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateImagesCommand extends Command
{

    protected $directoryList = [];

    protected $ftpConnection;

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('integration:images:update')
            ->setDescription('Copies images from media server to web server');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $notifier = new IntegrationEventNotify($output);

        $this->initFtpConnection($notifier);

        $products = Product::all();
        foreach ($products as $product) {
            if (empty($product->image) || is_file(DIR_IMAGE . $product->image)) {
                continue;
            }
            $notifier->notifyEvent("Copying image " . $product->image . " of product with id_erp " . $product->id_erp . " from mediaservers ftp");
            try {
                $this->imageFromMediaserverToWeb($product->image);
                $notifier->notifyEvent("Image copied successfully!", $notifier::SUCCESS_MESSAGE);
            } catch (\Throwable $e) {
                $notifier->notifyError($e);
            }

        }

        $this->closeFtpConnection();
    }

    protected function initFtpConnection(NotifyInterface $notify){

        $this->ftpConnection = ftp_connect(MEDIASERVER_FTP_SERVER) or die("Не удалось установить соединение с ".MEDIASERVER_FTP_SERVER);
        if (@ftp_login($this->ftpConnection, MEDIASERVER_FTP_USER, MEDIASERVER_FTP_PASS)) {
            $notify->notifyEvent("Произведен вход на ".MEDIASERVER_FTP_SERVER." под именем ".MEDIASERVER_FTP_USER);
        } else {
            $notify->notifyError("Не удалось войти под именем ".MEDIASERVER_FTP_USER);
        }
        ftp_pasv( $this->ftpConnection, true );

    }

    protected function closeFtpConnection(){
        ftp_close($this->ftpConnection);
    }

    protected function imageFromMediaserverToWeb(string $filename){
        $mediaServerFileLocation = str_replace("catalog/products/", "", $filename);
        $copyFileTo = DIR_IMAGE . $filename;
        $this->downloadFileFromFtp($mediaServerFileLocation, $copyFileTo);
    }

    protected function downloadFileFromFtp (string $fileFrom, string $copyFileTo)
    {
        $path = dirname($copyFileTo);
        if(!$this->isDirectoryExists($path)){ mkdir( $path, 0775, true ); }

        // try to download $remote_file and save it to $handle
        if(!ftp_get($this->ftpConnection, $copyFileTo, $fileFrom, FTP_BINARY, 0)){
            throw new \Exception("File ".$fileFrom." can`t be copied to ".$copyFileTo);
        }
    }

    protected function isDirectoryExists(string $directory){
        if(isset($this->directoryList[$directory])){
            return true;
        }
        if (is_dir($directory)){
            $this->directoryList[$directory] = 1;
            return true;
        }
        return false;
    }


}