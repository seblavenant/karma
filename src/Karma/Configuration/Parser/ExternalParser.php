<?php

namespace Karma\Configuration\Parser;

use Karma\Configuration\Parser;
use Gaufrette\Filesystem;

class ExternalParser extends AbstractGroupParser
{
    private
        $parser,
        $variables,
        $filesStatus;
    
    public function __construct(Parser $parser)
    {
        parent::__construct();

        $this->parser = $parser;
        $this->variables = array();
        $this->filesStatus = array();
    }
    
    public function parse($line)
    {
        $file = trim($line);
        
        $found = false;
        if($this->parser->getFileSystem()->has($file))
        {
            $found = true;
            $this->variables = $this->parser->parse($file);
        }
        
        $this->filesStatus[$file] = array(
            'found' => $found,
            'referencedFrom' => $this->currentFilePath,
        );
    }
    
    public function getExternalVariables()
    {
        return $this->variables;
    }
    
    public function getExternalFilesStatus()
    {
        return $this->filesStatus;
    }
}