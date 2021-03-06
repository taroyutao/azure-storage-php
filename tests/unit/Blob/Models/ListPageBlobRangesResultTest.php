<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Tests\Unit\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace MicrosoftAzure\Storage\Tests\unit\Blob\Models;

use MicrosoftAzure\Storage\Common\Internal\Utilities;
use MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult;
use MicrosoftAzure\Storage\Blob\Models\PageRange;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;

/**
 * Unit tests for class ListPageBlobRangesResultTest
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Tests\Unit\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class ListPageBlobRangesResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult::setPageRanges
     * @covers MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult::getPageRanges
     * @covers MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult::setContentLength
     * @covers MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult::getContentLength
     * @covers MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult::setETag
     * @covers MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult::getETag
     * @covers MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult::setLastModified
     * @covers MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult::getLastModified
     * @covers MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesResult::create
     */
    public function testCreate()
    {
        // Setup
        $headers   = TestResources::listPageRangeHeaders();
        $bodyArray = TestResources::listPageRangeBodyInArray();
        // Prepare expected page range
        $rawPageRanges = array();
        if (!empty($bodyArray['PageRange'])) {
            $rawPageRanges = Utilities::getArray($bodyArray['PageRange']);
        }
        
        $pageRanges = array();
        foreach ($rawPageRanges as $value) {
            $pageRanges[] = new PageRange(
                intval($value['Start']),
                intval($value['End'])
            );
        }
        // Prepare expected last modified date
        $expectedLastModified = Utilities::rfc1123ToDateTime($headers['Last-Modified']);

        // Test
        $result = ListPageBlobRangesResult::create($headers, $bodyArray);

        //Assert
        $this->assertEquals($pageRanges, $result->getPageRanges());
        $this->assertEquals($expectedLastModified, $result->getLastModified());
        $this->assertEquals($headers['Etag'], $result->getETag());
        $this->assertEquals($headers['x-ms-blob-content-length'], $result->getContentLength());
    }
}
