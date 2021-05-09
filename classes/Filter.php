<?php 

class BadWordsFilter 
{
    private $bad_words;

    public function __construct()
    {
        global $db;
        $this->bad_words = array();

        $db_bad_words = $db->get('bad_words');
        foreach($db_bad_words as $key => $bad_word)
        {
            $this->bad_words[] = $bad_word->word;
        }
    }

    public function filter($text)
    {
        if(count($this->bad_words) == 0)
            return $text;

        foreach($this->bad_words as $key => $bad_word)
        {
            $text = preg_replace("/\b$bad_word\b/u", str_repeat('*', mb_strlen($bad_word)), $text);
        }
        return $text;
    }
    public function getBadWords()
    {
        return $this->bad_words;
    }

    public function saveBadWords()
    {
        if(isset($_POST['save_bad_words']))
        {
            global $db;
            $respond = [];
            $respond['success'] = false;
            Session::start();

            $bad_words = filter_input(INPUT_POST, 'bad_words', FILTER_SANITIZE_STRING);
            $old_bad_words = filter_input(INPUT_POST, 'old_bad_words', FILTER_SANITIZE_STRING);

            if(Session::get('old_bad_words') != $old_bad_words)
            {
                $respond['message'] = 'Error has occur!';
                echo json_encode($respond);
                exit;
            }

            if($bad_words == $old_bad_words)
            {
                $respond['message'] = 'Nothing changed!';
                echo json_encode($respond);
                exit;
            }
            $bad_words_exploded = explode(",", $bad_words);

            $user_id = Session::get('id');

            $delete_query = "DELETE FROM bad_words";
            $query = "INSERT INTO bad_words (word, created_by) VALUES ";

            for($i = 0; $i < count($bad_words_exploded); $i++)
            {
                $single_bad_word = $bad_words_exploded[$i];
                $query .= " ( '$single_bad_word' , $user_id ) ";

                if($i == count($bad_words_exploded) - 1)
                    $query .= ";";
                else 
                    $query .= ",";
            }

            $db->customQuery($delete_query, [], "delete");

            if( $db->customQuery($query, [], "insert") )
            {
                $respond['message'] = 'Bad Words added successfully';
                $respond['success'] =  true;
                echo json_encode($respond);
                exit;
            }
        }
    }
}
