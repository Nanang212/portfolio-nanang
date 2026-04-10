import AdminLayout from '@/Layouts/AdminLayout';
import { FolderKanban, Briefcase, Cpu, MessageSquare, Eye } from 'lucide-react';
import { Link } from '@inertiajs/react';

const StatCard = ({ label, value, icon: Icon, color, href }) => (
    <div className="card p-6 flex items-center justify-between">
        <div>
            <p className="text-sm text-slate-500 dark:text-slate-400">{label}</p>
            <p className="text-3xl font-bold text-slate-900 dark:text-white mt-1">{value}</p>
        </div>
        <div className={`w-12 h-12 rounded-xl flex items-center justify-center ${color}`}>
            <Icon size={22} className="text-white"/>
        </div>
    </div>
);

export default function Dashboard({ stats }) {
    const s = stats || {};

    return (
        <AdminLayout title="Dashboard">
            <div className="space-y-8">
                {/* Stats grid */}
                <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <StatCard label="Total Projects" value={s.total_projects ?? 0} icon={FolderKanban} color="bg-primary-600"/>
                    <StatCard label="Published" value={s.published_projects ?? 0} icon={Eye} color="bg-green-500"/>
                    <StatCard label="Experience" value={s.total_experiences ?? 0} icon={Briefcase} color="bg-purple-500"/>
                    <StatCard label="Unread Messages" value={s.unread_messages ?? 0} icon={MessageSquare} color="bg-orange-500"/>
                </div>

                {/* Quick links */}
                <div className="card p-6">
                    <h2 className="font-bold text-slate-900 dark:text-white mb-4">Quick Actions</h2>
                    <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        {[
                            { href: '/admin/projects/create', label: 'Add Project', color: 'btn-primary' },
                            { href: '/admin/experiences/create', label: 'Add Experience', color: 'btn-secondary' },
                            { href: '/admin/skills/create', label: 'Add Skill', color: 'btn-secondary' },
                            { href: '/admin/about', label: 'Edit About Me', color: 'btn-secondary' },
                        ].map(a => (
                            <Link key={a.href} href={a.href} className={`${a.color} justify-center text-sm`}>
                                {a.label}
                            </Link>
                        ))}
                    </div>
                </div>

                {/* Info */}
                <div className="card p-6 border-l-4 border-primary-600">
                    <h3 className="font-semibold text-slate-800 dark:text-white mb-1">Welcome to CMS</h3>
                    <p className="text-slate-500 dark:text-slate-400 text-sm">
                        Manage your portfolio content from here. All changes are reflected on the public site immediately.
                        Toggle publish/unpublish to control visibility.
                    </p>
                </div>
            </div>
        </AdminLayout>
    );
}
