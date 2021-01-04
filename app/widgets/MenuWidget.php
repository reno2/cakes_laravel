
namespace App\Widgets;

use App\Widgets\Contract\ContractWidget;
use App\Menu;

class MenuWidget implements ContractWidget
{
    public function execute()
    {
        $data = ['main', 'second', 'theird'];

        return view('Widgets::menu', [
            'data' => $data
        ]);
    }
}
