<?php

namespace Bob;

task('default', array('test'));

task('test', array('phpunit.xml'), function() {
    echo `phpunit`;
});

fileTask('phpunit.xml', array('phpunit.dist.xml'), function() {
    copy('phpunit.dist.xml', 'phpunit.xml');
});
