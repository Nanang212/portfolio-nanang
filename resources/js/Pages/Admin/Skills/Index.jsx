import AdminLayout from '@/Layouts/AdminLayout';
import { Link, router, usePage } from '@inertiajs/react';
import { Plus, Pencil, Trash2, Cpu } from 'lucide-react';

const levelColor = {
    expert:       'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400',
    advanced:     'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
    intermediate: 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400',
    beginner:     'bg-gray-100 dark:bg-gray-800 text-gray-500',
};

export default function SkillsIndex({ skills }) {
    const { props } = usePage();
    const flash = props.flash || {};
    const destroy = (id) => confirm('Delete this skill?') && router.delete(`/admin/skills/${id}`);

    // Group by category
    const groups = {};
    (skills || []).forEach(s => { (groups[s.category] = groups[s.category] || []).push(s); });

    return (
        <AdminLayout title="Skills">
            <div className="space-y-6">
                {flash.success && (
                    <div className="p-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-xl text-sm border border-green-200 dark:border-green-700">
                        ✓ {flash.success}
                    </div>
                )}
                <div className="flex items-center justify-between">
                    <h2 className="font-bold text-slate-900 dark:text-white text-xl">Skills / Tech Stack</h2>
                    <Link href="/admin/skills/create" className="btn-primary text-sm">
                        <Plus size={16}/> Add Skill
                    </Link>
                </div>

                {Object.keys(groups).length === 0 ? (
                    <div className="card p-10 text-center text-slate-400">
                        <Cpu size={40} className="mx-auto mb-3 opacity-20"/>
                        <p>No skills yet.</p>
                    </div>
                ) : (
                    <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        {Object.entries(groups).map(([category, items]) => (
                            <div key={category} className="card p-5">
                                <h3 className="font-bold text-slate-800 dark:text-white mb-3 text-sm uppercase tracking-wider">{category}</h3>
                                <ul className="space-y-2">
                                    {items.map(skill => (
                                        <li key={skill.id} className="flex items-center justify-between">
                                            <div className="flex items-center gap-2">
                                                <span className="text-slate-700 dark:text-slate-300 text-sm">{skill.name}</span>
                                                <span className={`badge text-xs capitalize ${levelColor[skill.level] || levelColor.beginner}`}>{skill.level}</span>
                                            </div>
                                            <div className="flex gap-1">
                                                <Link href={`/admin/skills/${skill.id}/edit`} className="btn-ghost p-1">
                                                    <Pencil size={12}/>
                                                </Link>
                                                <button onClick={() => destroy(skill.id)} className="btn-ghost p-1 text-red-500">
                                                    <Trash2 size={12}/>
                                                </button>
                                            </div>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        ))}
                    </div>
                )}
            </div>
        </AdminLayout>
    );
}
