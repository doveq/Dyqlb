<?php
/**
 * 搜索模块
 *
 * ik分词
 * https://github.com/medcl/elasticsearch-analysis-ik
 *
 * elasticsearch-php
 * https://github.com/elastic/elasticsearch-php
*/


namespace App\Model;

use Elasticsearch\ClientBuilder;

class Search  {

    /**

        1，创建索引, 带逗号分词器，只有1个分片，0个复制，创建mapping

        PUT qbfzl
        {
          "settings": {
                "number_of_shards": 1,
                "number_of_replicas": 1,
                "analysis": {
                    "analyzer": {
                        "douhao": {
                            "type": "pattern",
                            "pattern": ","
                        }
                    }
                }
            },

          "mappings": {
            "posts": {
              "properties": {
                "id":    { "type": "integer"  },
                "type":    { "type": "byte"  },
                "tags":    { "type": "text", "analyzer": "douhao", "search_analyzer": "douhao" },
                "uid":    { "type": "integer"  },
                "title":     { "type": "text", "analyzer": "ik_max_word", "search_analyzer": "ik_max_word" },
                "description":     { "type": "text", "analyzer": "ik_max_word", "search_analyzer": "ik_max_word" },
                "title_thumb":      { "type": "keyword" },
                "title_video":      { "type": "keyword" },
                "link":      { "type": "keyword" },
                "link_md5":      { "type": "keyword" },
                "price":      { "type": "float" },
                "body":      { "type": "text", "analyzer": "ik_max_word", "search_analyzer": "ik_max_word" },
                "pros":      { "type": "integer" },
                "cons":      { "type": "integer" },
                "saves":      { "type": "integer" },
                "pv":      { "type": "integer" },
                "status":      { "type": "byte" },
                "created_at":  { "type": "date", "format": "yyyy-MM-dd HH:mm:ss" },
                "updated_at":  { "type": "date", "format": "yyyy-MM-dd HH:mm:ss" }
              }
            }
          }
        }
    */


    public $searchIndex = 'qbfzl';
    public $searchType = 'posts';

    /**
     * 添加或更新搜索数据
     *
     * @param array $data 搜索数据
    */
    public function put($data) {
        $client = ClientBuilder::create()->build();

        $params = [
            'index' => $this->searchIndex,
            'type' => $this->searchType,
            'id' => $data['id'],
            'body' => $data
        ];

        $response = $client->index($params);
    }

}
