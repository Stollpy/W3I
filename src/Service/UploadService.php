<?php


namespace App\Service;


use Symfony\Component\String\Slugger\SluggerInterface;

class UploadService
{
    /**
     * @var SluggerInterface
     */
    private $slugger;

    /**
     * UploadService constructor.
     * @param SluggerInterface $slugger
     */
    public function __construct(SluggerInterface $slugger){
        $this->slugger = $slugger;
    }

    /**
     * @param array $uploadedFile
     * @return string
     */
    public function uploadPulibc(array $uploadedFile)
    {
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName());
        $newFileName = $this->slugger->slug($originalFileName).'-'.uniqid().'.'.$uploadedFile->guessExtension();
        $uploadedFile->move('assets/upload', $newFileName);

        return 'http://localhost:8000/assets/upload/'.$newFileName;
    }
}