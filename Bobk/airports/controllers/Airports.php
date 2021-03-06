<?php namespace Bobk\airports\controllers;

//use Myth\Controllers\ThemedController;
use App\Controllers\BaseController;
use Bobk\airports\models\Airport_Model;

/**
 * Airports Controller
 *
 * Auto-generated by Sprint on 2020-11-16 20:58pm
 */
class Airports extends BaseController 
{

    /**
     * The type of caching to use. The default values are
     * set globally in the environment's start file, but
     * these will override if they are set.
     */
    protected $cache_type      = null;
    protected $backup_cache    = null;

    // If set, this language file will automatically be loaded.
    protected $language_file   = null;

    // If set, this model file will automatically be loaded.
    protected $model_file      = 'Airport_Model';

    
    /**
     * Allows per-controller override of theme.
     * @var null
     */
    protected $theme = null;

    /**
     * Per-controller override of the current layout file.
     * @var null
     */
    protected $layout = null;

    /**
     * The UIKit to make available to the template views.
     * @var string
     */
    protected $uikit = '';

    /**
     * The number of rows to show when paginating results.
     * @var int
     */
    protected $limit = 25;


    //--------------------------------------------------------------------

    public function __construct($skip=false)
    {
        // normal
        // if skip is true left with empty constructor so no iherited constructors will be called
//        if ($skip === false) {
//            parent::__construct();
//        }
        $this->model = new Airport_Model();
    }

    // ------------------------------------------------------------------
    /**
     * The default method called. Typically displays an overview of this
     * controller's domain.
     *
     * @return mixed
     */
    public function index()
    {
//        $model = new Airport_Model();

        //$rows = $this->Airport_model->as_array()
//									->find_all();
//        $this->setVar('rows', $rows);

        $data['rows'] = $this->model->findall();
		echo view('Bobk\airports\Views\orig_index', $data);
//		echo view('orig_index', $data);     // don't work
    }

    //--------------------------------------------------------------------

    /**
     * Create a single item.
     *
     * @return mixed
     */
    public function create()
    {
        helper('form');

        $model = new Airport_Model();

        if ($this->request->getMethod() === 'post' && $this->validate([
                'name' => 'required|min_length[3]|max_length[255]',
                'code'  => 'required',
            ]))
        {
            $model->save([
                'name' => $this->request->getPost('name'),
                'code'  => $this->request->getPost('code'),
                'description'  => $this->request->getPost('description'),
            ]);
    
            return redirect('bobk/airports');
        }
        else
        {
//            echo view('templates/header', ['title' => 'Create a news item']);
            echo view('Bobk\airports\Views\create');
//            echo view('templates/footer');
        }
    }

    //--------------------------------------------------------------------

    /**
     * Displays a single item.
     *
     * @param  int $id  The primary_key of the object.
     * @return mixed
     */
    public function show($id)
    {
//        $item = $this->airports/models/airport_model->find($id);
        $item = $this->airport_model->find($id);

        if (! $item)
        {
            $this->setMessage('Unable to find that item.', 'warning');
            redirect( site_url('airports') );
        }

        $this->setVar('item', $item);

		$this->render();
    }

    //--------------------------------------------------------------------

    /**
     * Updates a single item.
     *
     * @param  int $id  The primary_key of the object.
     * @return mixed
     */
    public function update($id)
    {
        helper('form');
        helper('inflector');

        if ($this->input->method() == 'post')
        {
            $post_data = $this->input->post();

//            if ($this->airports/models/airport_model->update($id, $post_data))
            if ($this->Airport_model->update($id, $post_data))
            {
                $this->setMessage('Successfully updated item.', 'success');
                redirect( site_url('airports') );
            }

//            $this->setMessage('Error updating item. '. $this->airports/models/airport_model->error(), 'danger');
            $this->setMessage('Error updating item. '. $this->airport_model->error(), 'danger');
        }

//        $item = $this->airports/models/airport_model->find($id);
        $item = $this->Airport_model->find($id);
        $this->setVar('item', $item);

		$this->render();
    }

    //--------------------------------------------------------------------

    /**
     * Deletes a single item
     *
     * @param  int $id  The primary_key of the object.
     * @return mixed
     */
    public function delete($id)
    {
//        if ($this->airports/models/airport_model->delete($id))
        if ($this->Airport_model->delete($id))
        {
            $this->setMessage('Successfully deleted item.', 'success');
            redirect( site_url('airports') );
        }

//        $this->setMessage('Error deleting item. '. $this->airports/models/airport_model->error(), 'danger');
        $this->setMessage('Error deleting item. '. $this->airport_model->error(), 'danger');
        redirect( site_url( 'airports' ) );
		
    }

    //--------------------------------------------------------------------

    /**
     * method to test HMVC controller to controller
     * Module::mycows::cows::testHMVC calls Module::Airports::airportTestHMVC (this)
     */
    public function airportTestHMVC()
    {
        $CI =& get_instance();      // the current controller instance (Eg: mycows::cows)

        $CI->load->helper('url');

        $offset = $CI->uri->segment( $CI->uri->total_segments() );
        $rows = $CI->Airport_model->as_array()
                                    ->find_all();

        return $rows;
    }

    public function moduleTest()
    {
        //$model = new Airport_Model();

        //$rows = $this->Airport_model->as_array()
//									->find_all();
//        $this->setVar('rows', $rows);

        //$data['rows'] = $model->findall();
        $data['title']="Module View";
		echo view('Bobk\airports\Views\moduleTest', $data);
    }

    // just a namespaced view folder
    public function testNSView()
    {
        $data['title']="NS View";
        echo view('Example\Blog\Views\BlogView', $data);
    }
}
